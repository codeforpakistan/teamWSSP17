package com.zeeroapps.wssp.services;

import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Intent;
import android.provider.Settings;
import android.support.v4.app.NotificationCompat;
import android.support.v4.app.TaskStackBuilder;
import android.util.Log;

import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.activities.DrawerActivity;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by fazalullah on 6/12/17.
 */

public class MyFirebaseMessagingService extends FirebaseMessagingService {
    private final String TAG = "MyApp_FirebaseMsg";
    private int notificationID = 1;
    private String complaintNo;

    @Override
    public void onMessageReceived(RemoteMessage remoteMessage) {
        super.onMessageReceived(remoteMessage);
        Log.e(TAG, "onMessageReceived: "+remoteMessage);
        Log.e(TAG, "From: " + remoteMessage.getFrom());

        if (remoteMessage.getNotification() != null){
            Log.e(TAG, "onMessageReceived: TITLE---"+remoteMessage.getNotification().getSound() );
            Log.e(TAG, "onMessageReceived: TITLE---"+remoteMessage.getNotification().getTitle() );
            Log.e(TAG, "onMessageReceived: BODY---"+remoteMessage.getNotification().getBody() );
            Log.e(TAG, "onMessageReceived: TAG---"+remoteMessage.getNotification().getTag() );
            sendNotification(remoteMessage.getNotification().getBody());
        }

        if (remoteMessage.getData().size() > 0){
            Log.e(TAG, "onMessageReceived: DATA---"+remoteMessage.getData().toString() );
            parseData(remoteMessage.getData().toString());
        }
    }

    private void parseData(String response){
        try {
            JSONObject jObj = new JSONObject(response);
            JSONObject jObjData = jObj.getJSONObject("data");
            complaintNo = jObjData.getString("title");
            String msg = jObjData.getString("message");
            sendNotification(msg);
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    public void sendNotification(String msg){
        notificationID += 1;
        String notificationMessage = msg;
        if (msg.toLowerCase().contains("pendingreview")){
            notificationMessage = "Your complaint is waiting for the reviews.";
        } else if (msg.toLowerCase().contains("inprogress")){
            notificationMessage = "Your complaint is under processing.";
        }else if (msg.toLowerCase().contains("completed")){
            notificationMessage = "Your complaint is now completed!";
        }
        NotificationManager notificationManager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
        NotificationCompat.Builder nBuilder = new NotificationCompat.Builder(this);
        nBuilder.setSmallIcon(R.drawable.ic_stat_notification)
                .setAutoCancel(true)
                .setContentTitle("Complaint status changed")
                .setContentText(notificationMessage)
                .setSound(Settings.System.DEFAULT_NOTIFICATION_URI)
                .setStyle(new NotificationCompat.BigTextStyle().bigText(notificationMessage));

        Intent intent = new Intent(this, DrawerActivity.class);
        intent.putExtra("CALLED_FROM_THANK_YOU_ACTIVITY", true);
        intent.putExtra("COMPLAINT_NUMBER", complaintNo);

        TaskStackBuilder stackBuilder = TaskStackBuilder.create(this);
        stackBuilder.addParentStack(DrawerActivity.class);
        stackBuilder.addNextIntent(intent);

        PendingIntent pendingIntent = stackBuilder.getPendingIntent(0, PendingIntent.FLAG_UPDATE_CURRENT);
        nBuilder.setContentIntent(pendingIntent);
        notificationManager.notify(notificationID, nBuilder.build());
    }

}
