package com.zeeroapps.wssp.receivers;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.util.Log;
import android.widget.Toast;

import com.zeeroapps.wssp.services.NetworkService;

/**
 * Created by fazalullah on 3/29/17.
 */

public class ConnectivityStateReceiver extends BroadcastReceiver {
    String TAG = "MyApp";

    @Override
    public void onReceive(Context context, Intent intent) {

        Log.e(TAG, "BROADCAST RECEIVER RUNNING");
        Intent serviceIntent = new Intent(context, NetworkService.class);

        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        if (cm == null) {
            return;
        } else if (cm.getActiveNetworkInfo() != null && cm.getActiveNetworkInfo().isConnected()) {
            Log.e(TAG, "Connected!");
            context.startService(serviceIntent);
        } else {
            Log.e(TAG, "Not Connected!");
            context.stopService(serviceIntent);
        }
    }
}
