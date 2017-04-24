package com.zeeroapps.wssp.services;

import android.app.Service;
import android.content.Intent;
import android.content.IntentFilter;
import android.database.Cursor;
import android.net.ConnectivityManager;
import android.os.IBinder;
import android.support.annotation.Nullable;
import android.util.Log;

import com.zeeroapps.wssp.SQLite.DatabaseHelper;
import com.zeeroapps.wssp.receivers.ConnectivityStateReceiver;

public class NetworkService extends Service {
    String TAG = "MyApp";

    public NetworkService() {
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        Log.e(TAG, "Service started");
        sendDataToDB();
        return Service.START_STICKY;
    }

    public void sendDataToDB(){
        DatabaseHelper dbHelper = new DatabaseHelper(this);
        Cursor cursor = dbHelper.getAllComplaints();
        if (cursor.moveToFirst()){
            do {
                Log.e(TAG, "sendDataToDB: " + cursor.getString(0));
                Log.e(TAG, "sendDataToDB: " + cursor.getString(1));
                Log.e(TAG, "sendDataToDB: " + cursor.getString(2));
            }while (cursor.moveToNext());
        }
//        unregisterBroadcast();
        dbHelper.deleteDataFromTable();
        stopSelf();
    }

    public void unregisterBroadcast(){
        ConnectivityStateReceiver csr = new ConnectivityStateReceiver();
        this.unregisterReceiver(csr);
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
