package com.zeeroapps.wssp.fragments;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.Bundle;
import android.support.design.widget.Snackbar;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.wang.avi.AVLoadingIndicatorView;
import com.zeeroapps.wssp.Model.ModelComplaints;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.adapter.CustomAdapterComplaints;
import com.zeeroapps.wssp.utils.AppController;
import com.zeeroapps.wssp.utils.ConfigWS;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

/**
 * A simple {@link Fragment} subclass.
 */
public class MyComplaintsFragment extends Fragment {
    String TAG = "MyApp";
    Context mContext;
    RecyclerView recyclerView;
    RelativeLayout layoutMain;
    AVLoadingIndicatorView avi;
    CustomAdapterComplaints customAdapter;
    ArrayList<ModelComplaints> compList;
    private String JSON_TAG = "JSON_ARRAY_TAG";

    SharedPreferences sp;

    public MyComplaintsFragment() {
        // Required empty public constructor
    }
    
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        mContext = inflater.getContext();
        // Inflate the layout for this fragment
        View v = inflater.inflate(R.layout.fragment_my_complaints, container, false);
        sp = inflater.getContext().getSharedPreferences(getString(R.string.sp), Context.MODE_PRIVATE);
        recyclerView = (RecyclerView) v.findViewById(R.id.recyclerView);
        layoutMain = (RelativeLayout) v.findViewById(R.id.mainLayout);
        avi = (AVLoadingIndicatorView) v.findViewById(R.id.loadingIndicator);
        avi.show();
        recyclerView.setLayoutManager(new LinearLayoutManager(mContext));
        compList = new ArrayList<ModelComplaints>();
        customAdapter = new CustomAdapterComplaints(mContext, compList);
        recyclerView.setAdapter(customAdapter);
        getDataFromDB();

        return v;
    }

    public static MyComplaintsFragment newInstance() {
        
        Bundle args = new Bundle();
        
        MyComplaintsFragment fragment = new MyComplaintsFragment();
        fragment.setArguments(args);
        return fragment;
    }

    public void getDataFromDB(){
        avi.show();

        final JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(ConfigWS.URL_MY_COMPLAINTS, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {
                Log.e(TAG, "Array Response: "+response );
                ModelComplaints complaint;
                try {
                    for (int i=0; i<response.length(); i++ ) {
                        JSONObject jObj = response.getJSONObject(i);
                        Log.e(TAG, "Object In Array Response: " + jObj);
                        complaint = new ModelComplaints();
                        complaint.setcImageUrl(jObj.getString("image_path"));
                        complaint.setcNumber(jObj.getString("c_number"));
                        complaint.setcStatus(jObj.getString("status"));
                        complaint.setcDateAndTime(jObj.getString("c_date_time"));
                        complaint.setcDetail(jObj.getString("c_details"));
                        complaint.setcType(jObj.getString("c_type"));
                        complaint.setcAddress(jObj.getString("bin_address"));
                        compList.add(complaint);
                    }

                    customAdapter.notifyDataSetChanged();
                } catch (JSONException e) {
                    e.printStackTrace();
                    Log.e(TAG, e.toString());

                }

                avi.hide();
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e(TAG, "onErrorResponse: "+error );
                if (error.toString().contains("NoConnectionError")) {
                    Snackbar.make(layoutMain, "Error in connection!", Snackbar.LENGTH_INDEFINITE).setActionTextColor(Color.RED).show();
                } else {
                    Snackbar.make(layoutMain, "Webservice not responding!", Snackbar.LENGTH_INDEFINITE).setActionTextColor(Color.RED).show();
                }
                avi.hide();
            }
        }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("mobilenumber", sp.getString(getString(R.string.spUMobile), null));
                return params;
            }
        };

        AppController.getInstance().addToRequestQueue(jsonArrayRequest, JSON_TAG);
    }


}
