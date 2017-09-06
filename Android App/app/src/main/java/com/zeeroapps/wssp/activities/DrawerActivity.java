package com.zeeroapps.wssp.activities;

import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.AppCompatActivity;
import android.view.MenuItem;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.google.firebase.analytics.FirebaseAnalytics;
import com.zeeroapps.wssp.fragments.MethodFragment;
import com.zeeroapps.wssp.fragments.MyComplaintsFragment;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.fragments.ViewPagerFragment;
import com.zeeroapps.wssp.utils.Constants;

public class DrawerActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener, View.OnClickListener {

    FragmentManager fragmentManager;

    DrawerLayout drawerLayout;
    NavigationView navigationView;
    ImageButton btnMenu;
    LinearLayout btnNewComp, btnMyComps, btnCall1334, btnMethod, btnFeedback;
    TextView tvName, tvZone, tvUC, tvNC;
    ImageView ivProfile;
    TextView btnLogout;
    SharedPreferences sp;
    SharedPreferences.Editor spEdit;
    private String TAG = "MyApp";
    private FirebaseAnalytics mFBAnalytics;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_drawer);

//        FirebaseCrash.report(new Exception("This is an exception!"));

        mFBAnalytics = FirebaseAnalytics.getInstance(this);
        fragmentManager = getSupportFragmentManager();

        sp = this.getSharedPreferences(getString(R.string.sp), this.MODE_PRIVATE);
        spEdit = sp.edit();

        Log.e(TAG, "onCreate: FB TOKEN "+sp.getString("FB_TOKEN", null) );

        Intent intent = getIntent();
        if (intent.getExtras() != null){
             if (intent.getExtras().getBoolean("CALLED_FROM_THANK_YOU_ACTIVITY")){
                 MyComplaintsFragment myComplaints = new MyComplaintsFragment();
                 if (intent.getExtras().getString("COMPLAINT_NUMBER") != null) {
                     Bundle bundle = new Bundle();
                     bundle.putString("COMPLAINT_NUMBER", intent.getExtras().getString("COMPLAINT_NUMBER"));
                     myComplaints.setArguments(bundle);
                 }
                 fragmentManager.beginTransaction().replace(R.id.container, myComplaints).commit();
             }
        }else {
            fragmentManager.beginTransaction().replace(R.id.container, ViewPagerFragment.newInstance()).commit();
        }
        initUIComponents();

    }

    @Override
    protected void onResume() {
        super.onResume();
        String scrName = "DRAWER SCREEN";

    }

    void initUIComponents(){
        btnMenu = (ImageButton) findViewById(R.id.btnMenu);
        drawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
        navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
        View hv = navigationView.getHeaderView(0);
        btnNewComp = (LinearLayout) findViewById(R.id.llNewComplaint);
        btnMyComps = (LinearLayout) findViewById(R.id.llMyComplaints);
        btnCall1334 = (LinearLayout) findViewById(R.id.llCall1334);
        btnMethod = (LinearLayout) findViewById(R.id.llMethod);
//        btnFeedback = (LinearLayout) hv.findViewById(R.id.llFeedback);
        tvName = (TextView) findViewById(R.id.tvName);
        tvZone = (TextView) findViewById(R.id.tvZone);
        tvNC = (TextView) findViewById(R.id.tvNC);
        tvUC = (TextView) findViewById(R.id.tvUC);
        ivProfile = (ImageView) findViewById(R.id.ivProfile);
        btnLogout = (TextView) findViewById(R.id.tvLogout);

        btnMenu.setOnClickListener(this);
        btnNewComp.setOnClickListener(this);
        btnMyComps.setOnClickListener(this);
        btnCall1334.setOnClickListener(this);
        btnMethod.setOnClickListener(this);
//        btnFeedback.setOnClickListener(this);
        btnLogout.setOnClickListener(this);

        setValues();
    }

    void setValues(){
        tvName.setText(sp.getString(getString(R.string.spUName), null));
        tvUC.setText("Union Council "+sp.getString(getString(R.string.spUC), null));
        tvNC.setText("Neighbourhood Council "+sp.getString(getString(R.string.spNC), null));
        Glide.with(this).load(Constants.URL_PROFILE_PIC+sp.getString(getString(R.string.spUPic), null)).placeholder(R.drawable.ic_person).into(ivProfile);
//        Picasso.with(this)
//                .load(Constants.URL_PROFILE_PIC+sp.getString(getString(R.string.spUPic), null))
//                .placeholder(R.drawable.ic_person)
//                .resize(300, 300)
//                .into(ivProfile);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.btnMenu:
                if (drawerLayout.isDrawerOpen(GravityCompat.START)) {
                    drawerLayout.closeDrawer(GravityCompat.START);
                } else {
                    drawerLayout.openDrawer(GravityCompat.START);
                }
                break;
            case R.id.llNewComplaint:
                changeFragment(ViewPagerFragment.newInstance());
                break;
            case R.id.llMyComplaints:
                changeFragment(MyComplaintsFragment.newInstance());
                break;
            case R.id.llCall1334:
                Bundle bundle = new Bundle();
                bundle.putString("user_phone_number", sp.getString(getString(R.string.spUMobile), null));
                mFBAnalytics.logEvent("call_1334", bundle);

                startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse("tel://1334")));
                break;
            case R.id.llMethod:
                changeFragment(MethodFragment.newInstance());
                break;
            case R.id.tvLogout:
                logoutUser();
                break;
        }
        if (drawerLayout.isDrawerOpen(GravityCompat.START)) {
            drawerLayout.closeDrawer(GravityCompat.START);
        }
    }

    private void logoutUser() {
        spEdit.putString(getString(R.string.spUMobile), null);
        spEdit.commit();
        startActivity(new Intent(DrawerActivity.this, LoginActivity.class));
        finish();
    }

    void changeFragment(Fragment fr){
        fragmentManager = getSupportFragmentManager();
        fragmentManager.beginTransaction().replace(R.id.container, fr).setTransition(FragmentTransaction.TRANSIT_FRAGMENT_FADE)
        .commit();
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_camera) {
            // Handle the camera action
        } else if (id == R.id.nav_gallery) {

        } else if (id == R.id.nav_slideshow) {

        } else if (id == R.id.nav_manage) {

        } else if (id == R.id.nav_share) {

        } else if (id == R.id.nav_send) {

        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

}
