package com.zeeroapps.wssp.SQLite;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

/**
 * Created by fazalullah on 4/6/17.
 */

public class DatabaseHelper extends SQLiteOpenHelper {

    private static final String DATABASE_NAME = "wssp_database.db";
    private static final String TABLE_NAME = "wssp_complaint";
    private static final String KEY_ID = "id";
    private static final String COMPLAINT_NUMBER = "complaint_id";
    private static final String COMPLAINT_TYPE = "complaint_type";

    private static final int DATABASE_VERSION = 1;

    public DatabaseHelper(Context context){
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        String CREATE_CONTACTS_TABLE = "CREATE TABLE " + TABLE_NAME + "("
                + KEY_ID + " INTEGER PRIMARY KEY," + COMPLAINT_NUMBER + " INTEGER,"
                + COMPLAINT_TYPE + " TEXT" + ")";
        db.execSQL(CREATE_CONTACTS_TABLE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int i, int i1) {
        db.execSQL("DROP TABLE IF EXISTS "+TABLE_NAME);
        onCreate(db);
    }

    public void addComplaintToDB(int cNo, String cType){
        SQLiteDatabase db = getWritableDatabase();

        ContentValues values = new ContentValues();
        values.put(COMPLAINT_NUMBER, cNo);
        values.put(COMPLAINT_TYPE, cType);
        db.insert(TABLE_NAME, null, values);
        db.close();
    }

    public Cursor getAllComplaints(){
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT * FROM "+TABLE_NAME, null);
        return cursor;
    }

    public void deleteDataFromTable(){
        SQLiteDatabase db = getWritableDatabase();
        db.delete(TABLE_NAME, null, null);
        db.close();
    }



}
