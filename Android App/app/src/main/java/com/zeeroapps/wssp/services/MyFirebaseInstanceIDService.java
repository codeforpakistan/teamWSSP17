package com.zeeroapps.wssp.services;

import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v4.content.LocalBroadcastManager;
import android.util.Log;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;
import com.zeeroapps.wssp.R;

/**
 * Created by fazalullah on 6/12/17.
 */

public class MyFirebaseInstanceIDService extends FirebaseInstanceIdService{
    private final String TAG = "MyApp_FirebaseID";

    @Override
    public void onTokenRefresh() {
        super.onTokenRefresh();
        String refreshToken = FirebaseInstanceId.getInstance().getToken();

        SharedPreferences sp = this.getSharedPreferences(getString(R.string.sp), MODE_PRIVATE);
        SharedPreferences.Editor spEdit = sp.edit();
        spEdit.putString("FB_TOKEN", refreshToken).commit();
    }

    private void sendRegistrationToServer(String token){
        Log.e(TAG, "sendRegistrationToServer: "+token );
    }
}
