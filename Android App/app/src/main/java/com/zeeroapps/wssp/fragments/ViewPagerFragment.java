package com.zeeroapps.wssp.fragments;


import android.Manifest;
import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.content.ContextCompat;
import android.support.v4.view.GestureDetectorCompat;
import android.support.v4.view.PagerTabStrip;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AlertDialog;
import android.text.Spannable;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.ImageSpan;
import android.util.Log;
import android.view.GestureDetector;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.Toast;

import com.viewpagerindicator.CirclePageIndicator;
import com.viewpagerindicator.IconPageIndicator;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.activities.NewComplaintActivity;
import com.zeeroapps.wssp.services.MyLocation;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;


/**
 * A simple {@link Fragment} subclass.
 */
public class ViewPagerFragment extends Fragment {

    public Context mContext;
    ViewPager viewPager;
    PagerTabStrip tabStrip;
    CirclePageIndicator cpIndicator;
    MyViewPagerAdapter vpAdapter;
    Button btnSelect;

    private String TAG = "MyApp";
    private static final int REQUEST_ID_MULTIPLE_PERMISSIONS = 1;
    private GestureDetector tapGestureDetector;

    public ViewPagerFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        mContext = inflater.getContext();
        View view = inflater.inflate(R.layout.fragment_view_pager, container, false);
        viewPager = (ViewPager) view.findViewById(R.id.viewPager);
        viewPager.setClipToPadding(false);
        viewPager.setPageMargin(5);
        tabStrip = (PagerTabStrip) view.findViewById(R.id.tabStrip);
        tabStrip.setDrawFullUnderline(false);
        tabStrip.setTabIndicatorColor(Color.parseColor("#ffc200"));
        vpAdapter = new MyViewPagerAdapter(getChildFragmentManager(), mContext);
        viewPager.setAdapter(vpAdapter);
        cpIndicator = (CirclePageIndicator)view.findViewById(R.id.pagerIndicator);
        cpIndicator.setViewPager(viewPager);
        btnSelect = (Button) view.findViewById(R.id.btnSelect);
        btnSelect.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                selectPage();
            }
        });
        tapGestureDetector = new GestureDetector(mContext, new GestureDetector.SimpleOnGestureListener(){
            @Override
            public boolean onSingleTapConfirmed(MotionEvent e) {
                Log.e(TAG, "onSingleTapConfirmed: "+viewPager.getCurrentItem() );
                selectPage();
                return super.onSingleTapConfirmed(e);
            }
        });
        viewPager.setOnTouchListener(new View.OnTouchListener() {
            public boolean onTouch(View v, MotionEvent event) {
                tapGestureDetector.onTouchEvent(event);
                return false;
            }
        });

        return view;
    }

    private void selectPage(){
        SharedPreferences sp = mContext.getSharedPreferences(getString(R.string.sp), Context.MODE_PRIVATE);
        sp.edit().putBoolean("OPEN_CAMERA", true).commit();
        if (checkAndRequestPermissions()) {
            MyLocation myLocation = new MyLocation(mContext);
            if (myLocation.canGetLocation()) {
                Intent intent = new Intent(mContext, NewComplaintActivity.class);
                intent.putExtra("selected_item", viewPager.getCurrentItem());
                startActivity(intent);
            } else {
                myLocation.showSettingsAlert();
            }
        }
    }

    public static ViewPagerFragment newInstance() {
        
        Bundle args = new Bundle();
        
        ViewPagerFragment fragment = new ViewPagerFragment();
        fragment.setArguments(args);
        return fragment;
    }


    private  boolean checkAndRequestPermissions() {
        int permissionCamera = ContextCompat.checkSelfPermission(mContext, Manifest.permission.CAMERA);
        int permissionStorage = ContextCompat.checkSelfPermission(mContext, Manifest.permission.WRITE_EXTERNAL_STORAGE);
        int permissionLocation = ContextCompat.checkSelfPermission(mContext, Manifest.permission.ACCESS_FINE_LOCATION);
        List<String> listPermissionsNeeded = new ArrayList<>();
        if (permissionStorage != PackageManager.PERMISSION_GRANTED) {
            listPermissionsNeeded.add(Manifest.permission.WRITE_EXTERNAL_STORAGE);
        }
        if (permissionCamera != PackageManager.PERMISSION_GRANTED) {
            listPermissionsNeeded.add(Manifest.permission.CAMERA);
        }
        if (permissionLocation != PackageManager.PERMISSION_GRANTED) {
            listPermissionsNeeded.add(Manifest.permission.ACCESS_FINE_LOCATION);
        }
        if (!listPermissionsNeeded.isEmpty()) {
            ActivityCompat.requestPermissions((Activity)mContext, listPermissionsNeeded.toArray(new String[listPermissionsNeeded.size()]),REQUEST_ID_MULTIPLE_PERMISSIONS);
            Log.e(TAG, "Returned falseeeee-------");
            return false;
        }
        Log.d(TAG, "Permission returned trueeeee-------");
        return true;

    }

    @Override
    public void onRequestPermissionsResult(int requestCode, String permissions[], int[] grantResults) {
        Log.d(TAG, "Permission callback called-------");
        switch (requestCode) {
            case REQUEST_ID_MULTIPLE_PERMISSIONS: {

                Map<String, Integer> perms = new HashMap<>();
                // Initialize the map with both permissions
                perms.put(Manifest.permission.CAMERA, PackageManager.PERMISSION_GRANTED);
                perms.put(Manifest.permission.WRITE_EXTERNAL_STORAGE, PackageManager.PERMISSION_GRANTED);
                perms.put(Manifest.permission.ACCESS_FINE_LOCATION, PackageManager.PERMISSION_GRANTED);
                // Fill with actual results from user
                if (grantResults.length > 0) {
                    for (int i = 0; i < permissions.length; i++)
                        perms.put(permissions[i], grantResults[i]);
                    // Check for both permissions
                    if (perms.get(Manifest.permission.CAMERA) == PackageManager.PERMISSION_GRANTED
                            && perms.get(Manifest.permission.WRITE_EXTERNAL_STORAGE) == PackageManager.PERMISSION_GRANTED) {
                        Log.d(TAG, "Camera, Storage & Location permissions granted");
                        Toast.makeText(mContext, "Permissions granted! Try now.", Toast.LENGTH_SHORT).show();
                        MyLocation myLocation = new MyLocation(mContext);
                        if (myLocation.canGetLocation()) {
                            Intent intent = new Intent(mContext, NewComplaintActivity.class);
                            intent.putExtra("selected_item", viewPager.getCurrentItem());
                            startActivity(intent);
                        } else {
                            myLocation.showSettingsAlert();
                        }
                        //chromClt.openChooser(chooserWV, chooserPathUri, chooserParams);
                        // process the normal flow
                        //else any one or both the permissions are not granted
                    } else {
                        Log.d(TAG, "Some permissions are not granted ask again ");
                        //permission is denied (this is the first time, when "never ask again" is not checked) so ask again explaining the usage of permission
//                        // shouldShowRequestPermissionRationale will return true
                        //show the dialog or snackbar saying its necessary and try again otherwise proceed with setup.
                        if (ActivityCompat.shouldShowRequestPermissionRationale((Activity)mContext, Manifest.permission.CAMERA) ||
                                ActivityCompat.shouldShowRequestPermissionRationale((Activity)mContext, Manifest.permission.WRITE_EXTERNAL_STORAGE) ||
                                ActivityCompat.shouldShowRequestPermissionRationale((Activity)mContext, Manifest.permission.ACCESS_FINE_LOCATION)) {
                            showDialogOK("Camera, Storage & Location Permissions are required for this app",
                                    new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            switch (which) {
                                                case DialogInterface.BUTTON_POSITIVE:
                                                    checkAndRequestPermissions();
                                                    break;
                                                case DialogInterface.BUTTON_NEGATIVE:
                                                    // proceed with logic by disabling the related features or quit the app.
                                                    break;
                                            }
                                        }
                                    });
                        }
                        //permission is denied (and never ask again is  checked)
                        //shouldShowRequestPermissionRationale will return false
                        else {
                            Toast.makeText(mContext, "Go to settings and enable permissions", Toast.LENGTH_LONG).show();
                            //                            //proceed with logic by disabling the related features or quit the app.
                        }
                    }
                }
                break;
            }
        }

    }

    private void showDialogOK(String message, DialogInterface.OnClickListener okListener) {
        new AlertDialog.Builder(mContext)
                .setMessage(message)
                .setPositiveButton("OK", okListener)
                .setNegativeButton("Cancel", okListener)
                .create()
                .show();
    }

    public static class MyViewPagerAdapter extends FragmentPagerAdapter {
        Context fContext;
        MyViewPagerAdapter(FragmentManager fm, Context context){
            super(fm);
            fContext = context;
        }

        @Override
        public Fragment getItem(int position) {
            switch (position){
                case 0:
                    return new DrainageFragment();
                case 1:
                    return new TrashBinFragment();
                case 2:
                    return new WaterSupplyFragment();
                case 3:
                    return new GarbageFragment();
                case 4:
                    return new OtherFragment();
                default:
                    return null;

            }
        }

        @Override
        public int getCount() {
            return 5;
        }

        @Override
        public CharSequence getPageTitle(int position) {

            String title = "";
            SpannableStringBuilder sb = null;

            switch (position){
                case 0:
                    title = "Drainage";
                    break;
                case 1:
                    title = "Trash Bin";
                    break;
                case 2:
                    title = "Water Supply";
                    break;
                case 3:
                    title = "Garbage";
                    break;
                case 4:
                    title = "Other";
                    break;
                default:
                    title = "";
            }

//            sb = new SpannableStringBuilder(title); // space added before text for convenience

//            Drawable drawable = ContextCompat.getDrawable(fContext,R.drawable.circle);
//            drawable.setBounds(10, 30, drawable.getIntrinsicWidth(), drawable.getIntrinsicHeight());
//            ImageSpan span = new ImageSpan(drawable, ImageSpan.ALIGN_BASELINE);
//            sb.setSpan(span, 0, 1, Spanned.SPAN_INTERMEDIATE);

            return title;
        }

        @Override
        public float getPageWidth(int position) {
            return 0.95f;
        }
    }

}
