package com.zeeroapps.wssp.activities;

import android.app.Activity;
import android.content.ComponentName;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.ConnectivityManager;
import android.net.Uri;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.design.widget.Snackbar;
import android.support.v4.content.FileProvider;
import android.os.Bundle;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.AlertDialog;
import android.text.TextUtils;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.view.ViewTreeObserver;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.wang.avi.AVLoadingIndicatorView;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.SQLite.DatabaseHelper;
import com.zeeroapps.wssp.receivers.ConnectivityStateReceiver;
import com.zeeroapps.wssp.services.MyLocation;
import com.zeeroapps.wssp.utils.AppController;
import com.zeeroapps.wssp.utils.CheckNetwork;
import com.zeeroapps.wssp.utils.Constants;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;
import java.util.Random;

public class NewComplaintActivity extends Activity {

    private static final int REQUEST_CAMERA_CODE = 1;
    ImageView ivPreview;
    EditText etAddress, etDetails;
    Button btnSubmit, btnRetake;
    TextView tvType, tvTypeUrdu, tvZone, tvUC, tvNC;
    AVLoadingIndicatorView avi;

    String TAG = "MyApp";
    private String mCurrentPhotoPath;
    private String encodedString;

    RelativeLayout llMain;
    private String tag_json_obj = "JSON_TAG";

    Double lat, lng;
    String gpsLocName;
    String complaintID;
    String complaintType;
    String currentDateandTime;
    String complaintTypeList[] = {"Drainage", "Trash Bin", "Water Supply", "Garbage", "Other"};
    String complaintTypeListUrdu[] = {"نکاسی آب", "بھرا ہوا گند کا ڈھبہ", "پانی کا مسئلہ", "کوڑا کرکٹ", "کوئی اور مسئلہ"};

    SharedPreferences sp;
    Boolean camFlag = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_new_complaint);

        sp = this.getSharedPreferences(getString(R.string.sp), MODE_PRIVATE);

        initUIComponents();
        if (!camFlag) {
            openCamera();
            camFlag = true;
            Log.e(TAG, "onCreate: flag is on");
        }
        getTypeIDandTime();
        Log.e(TAG, "onCreate: " );
    }

    void initUIComponents(){
        llMain = (RelativeLayout) findViewById(R.id.activity_new_complaint);
        ivPreview = (ImageView) findViewById(R.id.ivPreview);
        etAddress = (EditText) findViewById(R.id.etAddress);
        etDetails = (EditText) findViewById(R.id.etDetails);
//        btnRetake = (Button) findViewById(R.id.btnRetake);
        btnSubmit = (Button) findViewById(R.id.btnSubmit);
        tvType = (TextView) findViewById(R.id.tvTypeEng);
        tvTypeUrdu = (TextView) findViewById(R.id.tvTypeUrdu);
        tvZone = (TextView) findViewById(R.id.tvZone);
        tvUC = (TextView) findViewById(R.id.tvUC);
        tvNC = (TextView) findViewById(R.id.tvNC);
        avi = (AVLoadingIndicatorView) findViewById(R.id.loadingIndicator);
        avi.hide();

//        btnRetake.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                openCamera();
//            }
//        });
    }

    void getTypeIDandTime(){
        Intent intent = getIntent();
        if (intent.getExtras() != null){
            int i = intent.getExtras().getInt("selected_item");
            complaintType = complaintTypeList[i];
            tvType.setText(complaintType);
            tvTypeUrdu.setText(complaintTypeListUrdu[i]);
        }

        tvUC.setText("Union Council "+sp.getString(getString(R.string.spUC), null));
        tvNC.setText("Neighbourhood Council "+sp.getString(getString(R.string.spNC), null));

        Long time = System.currentTimeMillis()/1000;
        complaintID = Long.toString(time, 30).toUpperCase();
        Log.e(TAG, "Complaint Number: "+complaintID );

        DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        Date date = new Date();
        currentDateandTime = dateFormat.format(date);
        Log.e(TAG, "onCreate: "+currentDateandTime );
    }

    private void openCamera(){
        Intent cameraIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        if (cameraIntent.resolveActivity(getPackageManager()) != null){
            File photoFile = null;
            try {
                photoFile = createImageFile();
            } catch (IOException e) {
                e.printStackTrace();
            }
            if (photoFile != null){
                Uri photoURI = FileProvider.getUriForFile(this, "com.zeeroapps.wssp.fileprovider", photoFile);
                cameraIntent.putExtra(MediaStore.EXTRA_OUTPUT, photoURI);
                startActivityForResult(cameraIntent, REQUEST_CAMERA_CODE);
            }
        }
    }

    // Create image name
    private File createImageFile() throws IOException {
        String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String imageFileName = "JPEG_" + timeStamp + "_";
        File storageDir = getExternalFilesDir(Environment.DIRECTORY_PICTURES);
        File image = File.createTempFile(
                imageFileName,  /* prefix */
                ".jpg",         /* suffix */
                storageDir      /* directory */
        );

        // Save a file: path for use with ACTION_VIEW intents
        mCurrentPhotoPath = image.getAbsolutePath();
        return image;
    }

    private void handlePicAndCoordinates() {
        ViewTreeObserver vto = ivPreview.getViewTreeObserver();
        vto.addOnGlobalLayoutListener(new ViewTreeObserver.OnGlobalLayoutListener() {
            @Override
            public void onGlobalLayout() {
                ivPreview.getViewTreeObserver().removeGlobalOnLayoutListener(this);

                // Get the dimensions of the View
                int targetW = ivPreview.getMeasuredWidth();
                int targetH = ivPreview.getMeasuredHeight();

                // Get the dimensions of the bitmap
                BitmapFactory.Options bmOptions = new BitmapFactory.Options();
                bmOptions.inJustDecodeBounds = true;
                BitmapFactory.decodeFile(mCurrentPhotoPath, bmOptions);
                int photoW = bmOptions.outWidth;
                int photoH = bmOptions.outHeight;

                // Determine how much to scale down the image
                int scaleFactor = Math.min(photoW/targetW, photoH/targetH);

                // Decode the image file into a Bitmap sized to fill the View
                bmOptions.inJustDecodeBounds = false;
                bmOptions.inSampleSize = scaleFactor;
                bmOptions.inPurgeable = true;

                Bitmap bitmap = BitmapFactory.decodeFile(mCurrentPhotoPath, bmOptions);
                ivPreview.setImageBitmap(bitmap);
            }
        });

        MyLocation myLocation = new MyLocation(this);
        lat = myLocation.getLatitude();
        lng = myLocation.getLongitude();
        gpsLocName = myLocation.getLocationName();
        Log.e(TAG, "Latitude: "+lat+" Longitude: "+lng+" Location Name: "+gpsLocName );
        myLocation.stopUsingGPS();
        stopService(new Intent(NewComplaintActivity.this, MyLocation.class));
    }

    /**
     * Method To convert image to base64 format
     * @return
     */
     private String encodeImage(){
        Bitmap bitmap = BitmapFactory.decodeFile(mCurrentPhotoPath);
        ByteArrayOutputStream stream = new ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.JPEG, 25, stream);
        byte[] array = stream.toByteArray();
        encodedString = Base64.encodeToString(array, 0);
        return Base64.encodeToString(array, 0);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == REQUEST_CAMERA_CODE && resultCode == RESULT_OK){
            handlePicAndCoordinates();
        } else if (requestCode == REQUEST_CAMERA_CODE && resultCode == RESULT_CANCELED){
            Intent mainIntent = new Intent(NewComplaintActivity.this, DrawerActivity.class);
            mainIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            startActivity(mainIntent);
            finish();
        }
    }

    public void validateFields(){
        if (TextUtils.isEmpty(etAddress.getText())){
            etAddress.requestFocus();
            etAddress.setError("Enter valid Address!");
            return;
        }

        btnSubmit.setEnabled(false);
        if (CheckNetwork.isOnline(this)){
            Log.e(TAG, "Interent Available - Data submitted");
            sendDataToDB();
        }else {
            Log.e(TAG, "No Interent Available - Data saved to SQLite");
            storeDataInSQLite();
            registerBroadcast();
        }
    }

    public void submitData(View v){
        validateFields();
    }

    public void sendDataToDB(){
        avi.show();
        StringRequest jsonReq = new StringRequest(Request.Method.POST, Constants.URL_NEW_COMP,
                new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.e(TAG, response.toString());
                avi.hide();
                Snackbar.make(llMain, response, Snackbar.LENGTH_LONG).show();
                if (response.toLowerCase().contains("success")){
                    Intent intent = new Intent(NewComplaintActivity.this, ThankYouActivity.class);
                    intent.putExtra("COMPLAINT_NUMBER", complaintID);
                    startActivity(intent);
                    finish();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e(TAG, error.toString());
                avi.hide();
                if (error.toString().contains("NoConnectionError")) {
                    Snackbar.make(llMain, "Internet Not Available!", Snackbar.LENGTH_LONG).show();
                } else {
                    Snackbar.make(llMain, "Server not responding!", Snackbar.LENGTH_LONG).show();
                }
            }
        }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("account_id", sp.getString(getString(R.string.spUID), null));
                params.put("c_number", complaintID);
                params.put("c_type", complaintType);
                params.put("c_date_time", currentDateandTime);
                params.put("c_details", etDetails.getText().toString());
                params.put("image_path", encodeImage());
                params.put("latitude", lat.toString());
                params.put("longitude", lng.toString());
                params.put("bin_address", etAddress.getText().toString());
                params.put("status", "pendingreview");
                return params;
            }
        };
        jsonReq.setRetryPolicy(new DefaultRetryPolicy(0,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        AppController.getInstance().addToRequestQueue(jsonReq, tag_json_obj);
    }

    public void storeDataInSQLite(){
        DatabaseHelper dbHelper = new DatabaseHelper(this);
        Boolean dataStored = dbHelper.addComplaintToDB(
                sp.getString(getString(R.string.spUID), null),
                complaintID,
                complaintType,
                currentDateandTime,
                encodeImage(),
                lat.toString(),
                lng.toString(),
                etAddress.getText().toString(),
                etDetails.getText().toString(),
                "pendingreview"
        );
        if (dataStored){
            AlertDialog.Builder alert = new AlertDialog.Builder(this);
            alert.setTitle("Internet Not available!")
                    .setMessage("Complaint temporarily stored in mobile database. Connect your phone to internet as soon as possible.")
                    .setCancelable(false)
                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            Intent intent = new Intent(NewComplaintActivity.this, DrawerActivity.class);
                            startActivity(intent);
                            finish();
                        }
                    }).show();
        }
    }

    private void registerBroadcast() {
        PackageManager pm = getPackageManager();
        ComponentName cn = new ComponentName(NewComplaintActivity.this, ConnectivityStateReceiver.class);
        pm.setComponentEnabledSetting(cn, PackageManager.COMPONENT_ENABLED_STATE_ENABLED, PackageManager.DONT_KILL_APP);
        Toast.makeText(this, "Enabled!", Toast.LENGTH_SHORT).show();

    }

}
