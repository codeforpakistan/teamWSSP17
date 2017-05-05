package com.zeeroapps.wssp.activities;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import com.google.android.gms.analytics.HitBuilders;
import com.google.android.gms.analytics.Tracker;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.utils.AppController;

public class ThankYouActivity extends Activity {

    String complaintNo = "12345";
    TextView tvEng, tvUrdu;
    Button btnStatus;
    String TAG = "MyApp";
    Tracker mTracker;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_thank_you);

        tvEng = (TextView) findViewById(R.id.tvThankEng);
        tvUrdu = (TextView) findViewById(R.id.tvThankUrdu);
        btnStatus = (Button) findViewById(R.id.btnCheckStatus);
        btnStatus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(ThankYouActivity.this, DrawerActivity.class);
                intent.putExtra("CALLED_FROM_THANK_YOU_ACTIVITY", true);
                startActivity(intent);
                finish();
            }
        });

        Intent intent = getIntent();
        if (intent.getExtras() != null){
            complaintNo = intent.getExtras().getString("COMPLAINT_NUMBER");
        }

        String strThanks = getString(R.string.thank_you_eng);
        strThanks = strThanks.replace("#C_NO#", complaintNo);
        tvEng.setText(strThanks);

        strThanks = getString(R.string.thank_you_urdu);
        strThanks = strThanks.replace("#C_NO#", complaintNo);
        tvUrdu.setText(strThanks);

        AppController appController = (AppController) getApplication();
        mTracker = appController.getDefaultTracker();
    }

    @Override
    protected void onResume() {
        super.onResume();
        String scrName = "LOGIN SCREEN";
        Log.e(TAG, "onResume: "+scrName);
        mTracker.setScreenName(scrName);
        mTracker.send(new HitBuilders.ScreenViewBuilder().build());
    }
}
