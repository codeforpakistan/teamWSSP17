package com.zeeroapps.wssp.fragments;


import android.content.Context;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.content.ContextCompat;
import android.text.method.ScrollingMovementMethod;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import com.zeeroapps.wssp.R;


/**
 * A simple {@link Fragment} subclass.
 */
public class MethodFragment extends Fragment {

    Button btnEng, btnUrdu;
    TextView tvAbout;
    Context mContext;

    public MethodFragment() {
        // Required empty public constructor
    }

    public static MethodFragment newInstance() {

        Bundle args = new Bundle();

        MethodFragment fragment = new MethodFragment();
        fragment.setArguments(args);
        return fragment;
    }
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        mContext = inflater.getContext();
        View view = inflater.inflate(R.layout.fragment_method, container, false);
        btnEng = (Button) view.findViewById(R.id.btnEng);
        btnUrdu = (Button) view.findViewById(R.id.btnUrdu);
        tvAbout = (TextView) view.findViewById(R.id.tvAboutSP);
        tvAbout.setMovementMethod(new ScrollingMovementMethod());

        btnEng.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                tvAbout.setText(getString(R.string.how_to_eng));
                btnUrdu.setBackground(ContextCompat.getDrawable(mContext, R.drawable.round_corner_top_right));
                btnEng.setBackgroundColor(ContextCompat.getColor(mContext, R.color.clr_wssp_yellow));
                btnUrdu.setTextColor(ContextCompat.getColor(mContext, R.color.clr_wssp_yellow));
                btnEng.setTextColor(Color.WHITE);
            }
        });

        btnUrdu.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                tvAbout.setText(getString(R.string.how_to_urdu));
                btnEng.setBackground(ContextCompat.getDrawable(mContext, R.drawable.round_corner_top_left));
                btnUrdu.setBackgroundColor(ContextCompat.getColor(mContext, R.color.clr_wssp_yellow));
                btnEng.setTextColor(ContextCompat.getColor(mContext, R.color.clr_wssp_yellow));
                btnUrdu.setTextColor(Color.WHITE);
            }
        });
        return view;
    }

}
