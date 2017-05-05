package com.zeeroapps.wssp.services;

import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.ComponentName;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.net.ConnectivityManager;
import android.os.IBinder;
import android.provider.Settings;
import android.support.annotation.Nullable;
import android.support.design.widget.Snackbar;
import android.support.v4.app.NotificationCompat;
import android.support.v4.app.TaskStackBuilder;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.SQLite.DatabaseHelper;
import com.zeeroapps.wssp.activities.DrawerActivity;
import com.zeeroapps.wssp.activities.NewComplaintActivity;
import com.zeeroapps.wssp.activities.ThankYouActivity;
import com.zeeroapps.wssp.receivers.ConnectivityStateReceiver;
import com.zeeroapps.wssp.utils.AppController;
import com.zeeroapps.wssp.utils.Constants;

import java.util.HashMap;
import java.util.Map;

public class NetworkService extends Service {
    String TAG = "MyApp";
    private String tag_json_obj = "JSON_TAG";

    String cID, userID, cNo, cType, cTime, cDetail, cImage, cLat, cLng, cAddress, cStatus;
    int notificationID = 1;

    public NetworkService() {
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        Log.e(TAG, "Service started");
        getDatafromSQLite();
        return Service.START_STICKY;
    }

    public void getDatafromSQLite(){
        DatabaseHelper dbHelper = new DatabaseHelper(this);
        Cursor cursor = dbHelper.getAllComplaints();
        if (cursor.moveToFirst()){
            do {
                Log.e(TAG, "id: " + cursor.getString(0));
                Log.e(TAG, "user id: " + cursor.getString(1));
                Log.e(TAG, "c no: " + cursor.getString(2));
                Log.e(TAG, "type: " + cursor.getString(3));
                Log.e(TAG, "c time: " + cursor.getString(4));
                Log.e(TAG, "c det: " + cursor.getString(5));
                Log.e(TAG, "c image: " + cursor.getString(6));
                Log.e(TAG, "c lat: " + cursor.getString(7));
                Log.e(TAG, "c lng: " + cursor.getString(8));
                Log.e(TAG, "c address: " + cursor.getString(9));
                Log.e(TAG, "c status: " + cursor.getString(10));

                cID = cursor.getString(0);
                userID = cursor.getString(1);
                cNo = cursor.getString(2);
                cType = cursor.getString(3);
                cTime = cursor.getString(4);
                cDetail = cursor.getString(5);
                cImage = cursor.getString(6);
                cLat = cursor.getString(7);
                cLng = cursor.getString(8);
                cAddress = cursor.getString(9);
                cStatus = cursor.getString(10);
                sendDataToDB();
            }while (cursor.moveToNext());
        }
        unregisterBroadcast();
        dbHelper.deleteDataFromTable();
        stopSelf();
    }

    public void sendDataToDB(){
        StringRequest jsonReq = new StringRequest(Request.Method.POST, Constants.URL_NEW_COMP,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.e(TAG, response.toString());
                        if (response.toLowerCase().contains("success")){
                            sendNotification();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e(TAG, error.toString());
            }
        }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("account_id", userID);
                params.put("c_number", cNo);
                params.put("c_type", cType);
                params.put("c_date_time", cTime);
                params.put("c_details", cDetail);
                params.put("image_path", cImage);
                params.put("latitude", cLat);
                params.put("longitude", cLng);
                params.put("bin_address", cAddress);
                params.put("status", cStatus);
                return params;
            }
        };
        jsonReq.setRetryPolicy(new DefaultRetryPolicy(0,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        AppController.getInstance().addToRequestQueue(jsonReq, tag_json_obj);
    }

    public void sendNotification(){
        notificationID += 1;
        String notificationMessage = "Your complaint has been submitted. "+cNo+" is your complaint number.";
        NotificationManager notificationManager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
        NotificationCompat.Builder nBuilder = new NotificationCompat.Builder(this);
        nBuilder.setSmallIcon(R.drawable.ic_stat_notification)
                .setAutoCancel(true)
                .setContentTitle("Complaint sent!")
                .setContentText(notificationMessage)
                .setSound(Settings.System.DEFAULT_NOTIFICATION_URI)
                .setStyle(new NotificationCompat.BigTextStyle().bigText(notificationMessage));

        Intent intent = new Intent(this, DrawerActivity.class);
        intent.putExtra("CALLED_FROM_THANK_YOU_ACTIVITY", true);

        TaskStackBuilder stackBuilder = TaskStackBuilder.create(this);
        stackBuilder.addParentStack(DrawerActivity.class);
        stackBuilder.addNextIntent(intent);

        PendingIntent pendingIntent = stackBuilder.getPendingIntent(0, PendingIntent.FLAG_UPDATE_CURRENT);
        nBuilder.setContentIntent(pendingIntent);
        notificationManager.notify(notificationID, nBuilder.build());
    }

    public void unregisterBroadcast(){
        PackageManager pm  = this.getPackageManager();
        ComponentName componentName = new ComponentName(NetworkService.this, ConnectivityStateReceiver.class);
        pm.setComponentEnabledSetting(componentName,PackageManager.COMPONENT_ENABLED_STATE_DISABLED,
                PackageManager.DONT_KILL_APP);
        Log.e(TAG, "Broadcast: DISABLED!" );
    }

    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    @Override
    public void onDestroy() {
        Log.e(TAG, "Network Service Destroyed!");
    }
}
