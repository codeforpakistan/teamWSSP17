package com.zeeroapps.wssp.activities;

import android.app.Activity;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.widget.TextView;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.utils.AppController;
import com.zeeroapps.wssp.utils.ConfigWS;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class MyComplaintsActivity extends Activity {

    private String TAG = "MyApp";
    private String JSON_TAG = "JSON_ARRAY_TAG";

    TextView tvComp;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_complaints);

        initUIComponents();
        getDataFromDB();
    }

    private void initUIComponents() {
        tvComp = (TextView) findViewById(R.id.tvComp);
    }

    public void getDataFromDB(){
        final JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(ConfigWS.URL_MY_COMPLAINTS, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {
                Log.e(TAG, "Array Response: "+response );
                tvComp.setText(response.toString());
                try {
                    for (int i=0; i<response.length(); i++ ) {
                        JSONObject jObj = response.getJSONObject(i);
                        Log.e(TAG, "Object In Array Response: " + jObj);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        });

        AppController.getInstance().addToRequestQueue(jsonArrayRequest, JSON_TAG);
    }
}
