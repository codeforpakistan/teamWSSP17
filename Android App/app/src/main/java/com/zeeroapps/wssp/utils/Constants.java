package com.zeeroapps.wssp.utils;

import android.content.SharedPreferences;

import com.zeeroapps.wssp.BuildConfig;

/**
 * Created by Zeero on 10/27/2016.
 */
public class Constants {

    public static final String HOST_URL = BuildConfig.END_POINT;
    public static final String URL_LOGIN = BuildConfig.END_POINT + "index.php/main/login_validations";
    public static final String URL_REG = BuildConfig.END_POINT + "user/registration_app";
    public static final String URL_NEW_COMP = BuildConfig.END_POINT + "main/add_comp/add";
    public static final String URL_MY_COMPLAINTS = BuildConfig.END_POINT + "main/add_comp/list";
    public static final String URL_MEMBERS = BuildConfig.END_POINT + "main/members_app";
    public static final String URL_PROFILE_PIC = BuildConfig.END_POINT + "uploads/profile/";
    public static final String URL_SEND_FEEDBACK = BuildConfig.END_POINT + "main/add_comp/feedback";
}
