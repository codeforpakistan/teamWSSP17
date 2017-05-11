package com.zeeroapps.wssp.activities;

import android.app.Activity;
import android.graphics.Color;
import android.support.v4.content.ContextCompat;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.utils.AppController;

public class HelpActivity extends Activity {

    Button btnEng, btnUrdu;
    TextView tvAbout;
    String TAG = "MyApp";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_help);

        btnEng = (Button) findViewById(R.id.btnEng);
        btnUrdu = (Button) findViewById(R.id.btnUrdu);
        tvAbout = (TextView) findViewById(R.id.tvAboutSP);
        tvAbout.setMovementMethod(new ScrollingMovementMethod());

        btnEng.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                tvAbout.setText(getString(R.string.str_safa_pekhawar_eng));
                btnUrdu.setBackground(ContextCompat.getDrawable(HelpActivity.this, R.drawable.round_corner_top_right));
                btnEng.setBackgroundColor(ContextCompat.getColor(HelpActivity.this, R.color.clr_wssp_yellow));
                btnUrdu.setTextColor(ContextCompat.getColor(HelpActivity.this, R.color.clr_wssp_yellow));
                btnEng.setTextColor(Color.WHITE);
            }
        });

        btnUrdu.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                tvAbout.setText(getString(R.string.str_safa_pekhawar_urdu));
                btnEng.setBackground(ContextCompat.getDrawable(HelpActivity.this, R.drawable.round_corner_top_left));
                btnUrdu.setBackgroundColor(ContextCompat.getColor(HelpActivity.this, R.color.clr_wssp_yellow));
                btnEng.setTextColor(ContextCompat.getColor(HelpActivity.this, R.color.clr_wssp_yellow));
                btnUrdu.setTextColor(Color.WHITE);
            }
        });
    }

    @Override
    protected void onResume() {
        super.onResume();
        String scrName = "HELP SCREEN";
    }
}
