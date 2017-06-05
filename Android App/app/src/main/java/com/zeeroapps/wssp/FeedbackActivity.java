package com.zeeroapps.wssp;

import android.content.Intent;
import android.content.SharedPreferences;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RelativeLayout;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.wang.avi.AVLoadingIndicatorView;
import com.zeeroapps.wssp.activities.DrawerActivity;
import com.zeeroapps.wssp.utils.AppController;
import com.zeeroapps.wssp.utils.Constants;
import com.zeeroapps.wssp.utils.SHA1;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.security.NoSuchAlgorithmException;
import java.util.HashMap;
import java.util.Map;

public class FeedbackActivity extends AppCompatActivity {

    RelativeLayout rlFeedbackMain;
    EditText etFeedback;
    Button btnSendFeedback;
    AVLoadingIndicatorView avi;

    SharedPreferences sp;
    public final static String TAG = "MyApp_Feedback";
    private String tag_json_obj = "JSON_STRING_REQUEST";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_feedback);

        sp = this.getSharedPreferences(getString(R.string.sp), MODE_PRIVATE);
        initUIControls();
    }

    void initUIControls(){
        rlFeedbackMain = (RelativeLayout) findViewById(R.id.activity_feedback);
        etFeedback = (EditText) findViewById(R.id.etFeedback);
        btnSendFeedback = (Button) findViewById(R.id.btnSendFeedback);
        avi = (AVLoadingIndicatorView) findViewById(R.id.loadingIndicator);
    }

    public void onClickSendFeedback(View v){
        if (TextUtils.isEmpty(etFeedback.getText().toString())){
            etFeedback.setError("Enter your feedback please!");
        }else {
            sendFeedback();
        }
    }

    public void sendFeedback() {

        StringRequest jsonReq = new StringRequest(Request.Method.POST, Constants.URL_SEND_FEEDBACK, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.e(TAG, response.toString());

                    Snackbar.make(rlFeedbackMain, response, Snackbar.LENGTH_LONG).show();
                    if (response.toLowerCase().contains("success")) {
                        Intent intent = new Intent(FeedbackActivity.this, DrawerActivity.class);
                        startActivity(intent);
                    }
                avi.hide();
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e(TAG, error.toString());
                if (error.toString().contains("NoConnectionError")) {
                    Snackbar.make(rlFeedbackMain, "Error in connection!", Snackbar.LENGTH_LONG).show();
                } else {
                    Snackbar.make(rlFeedbackMain, "Server not responding!", Snackbar.LENGTH_LONG).show();
                }
                avi.hide();
            }
        }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("c_number", "21B323A");
                params.put("mobilenumber", sp.getString(getString(R.string.spUMobile), null));
                params.put("feedback", etFeedback.getText().toString());
                return params;
            }
        };
        AppController.getInstance().addToRequestQueue(jsonReq, tag_json_obj);
    }

}
