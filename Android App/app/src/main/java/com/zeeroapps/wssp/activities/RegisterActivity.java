package com.zeeroapps.wssp.activities;

import android.content.Intent;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.util.Patterns;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.wang.avi.AVLoadingIndicatorView;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.utils.AppController;
import com.zeeroapps.wssp.utils.Constants;
import com.zeeroapps.wssp.utils.SHA1;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.security.NoSuchAlgorithmException;
import java.util.HashMap;
import java.util.Map;

public class RegisterActivity extends AppCompatActivity {

    EditText etName, etPhone, etEmail, etAddress, etPassword, etConfirmPassword;
    Button signupBtn;
    AVLoadingIndicatorView avi;
    RelativeLayout register_layout;
    String passwordSHA1;
    private static final String TAG = "MyApp";
    private String tag_json_obj = "JSON_TAG";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        initiView();
    }

    private void initiView() {
        etName = (EditText) findViewById(R.id.etName);
        etPhone = (EditText) findViewById(R.id.etPhone);
        etEmail = (EditText) findViewById(R.id.etEmail);
        etAddress = (EditText) findViewById(R.id.etAddress);
        etPassword = (EditText) findViewById(R.id.etPassword);
        etConfirmPassword = (EditText) findViewById(R.id.etConfirmPassword);
        signupBtn = (Button) findViewById(R.id.signup);
        avi = (AVLoadingIndicatorView) findViewById(R.id.reg_loadingIndicator);
        register_layout = (RelativeLayout) findViewById(R.id.register_layout);

        avi.hide();
    }

    public void Signup(View view) {
        String name = etName.getText().toString().trim();
        String phone = etPhone.getText().toString().trim();
        String email = etEmail.getText().toString().trim();
        String address = etAddress.getText().toString().trim();
        String password = etPassword.getText().toString().trim();
        String confirmPassword = etConfirmPassword.getText().toString().trim();

        if (TextUtils.isEmpty(name)){
            etName.requestFocus();
            etName.setError("Enter name!");
        }else if (TextUtils.isEmpty(phone) || phone.length() < 11){
            etPhone.requestFocus();
            etPhone.setError("Enter valid phone number!");
        }else if (TextUtils.isEmpty(email) || !isValidEmail(email)){
            etEmail.requestFocus();
            etEmail.setError("Enter valid email address!");
        }else if (TextUtils.isEmpty(address)){
            etAddress.requestFocus();
            etAddress.setError("Enter address!");
        }else if (password.length() < 5){
            etPassword.requestFocus();
            etPassword.setError("Password must be 5 characters long!");
        }else if (TextUtils.isEmpty(confirmPassword)){
            etConfirmPassword.requestFocus();
            etConfirmPassword.setError("Enter confirm password!");
        }else if (!confirmPassword.equals(password)){
            etConfirmPassword.requestFocus();
            etConfirmPassword.setError("Password not matched!");
        } else {
            avi.show();
            loginWS(name, phone, email, address, password, confirmPassword);
        }
    }

    public void loginWS(final String name, final String phone, final String email, final String address, final String password, final String confirmPassword) {
        try {
            passwordSHA1 = SHA1.encrypt(password);
            Log.e(TAG, "loginWS: " + passwordSHA1);
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }

        StringRequest jsonReq = new StringRequest(Request.Method.POST, Constants.URL_REG, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.e(TAG, response.toString());

                try {
                    JSONObject jObj = new JSONObject(response.toString());
                    String status = jObj.getString("status");

                    Snackbar.make(register_layout, status, Snackbar.LENGTH_LONG).show();
                    if (status.toLowerCase().contains("success")) {
                        Toast.makeText(RegisterActivity.this, "Successfully Registered\n Please login now", Toast.LENGTH_SHORT).show();
                        startActivity(new Intent(RegisterActivity.this, LoginActivity.class));
                    }else{
                        Snackbar.make(register_layout, "Registration failed! Try Again", Snackbar.LENGTH_LONG).show();
                        avi.hide();
                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                }
                avi.hide();
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e(TAG, error.toString());
                if (error.toString().contains("NoConnectionError")) {
                    Snackbar.make(register_layout, "Error in connection!", Snackbar.LENGTH_LONG).show();
                } else {
                    Snackbar.make(register_layout, "Server not responding!", Snackbar.LENGTH_LONG).show();
                }
                avi.hide();
            }
        }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("fullname", name);
                params.put("mobilenumber", phone);
                params.put("emailad", email);
                params.put("address", address);
                params.put("roll", "0");
                params.put("password", password);
                params.put("cpassword", confirmPassword);

                Log.e(TAG, "Params: "+params.toString() );
                return params;
            }
        };
        AppController.getInstance().addToRequestQueue(jsonReq, tag_json_obj);
    }

    public void gotoLogin(View view) {
        finish();
    }

    public static boolean isValidEmail(CharSequence target) {
        return (!TextUtils.isEmpty(target) && Patterns.EMAIL_ADDRESS.matcher(target).matches());
    }
}
