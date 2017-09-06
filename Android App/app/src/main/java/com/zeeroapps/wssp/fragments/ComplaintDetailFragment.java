package com.zeeroapps.wssp.fragments;


import android.graphics.Color;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.text.method.ScrollingMovementMethod;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.google.firebase.analytics.FirebaseAnalytics;
import com.zeeroapps.wssp.R;
import com.zeeroapps.wssp.utils.AppController;


/**
 * A simple {@link Fragment} subclass.
 */
public class ComplaintDetailFragment extends Fragment {

    TextView tvNo, tvComplaintStatus, tvComplaintStatusUrdu, tvDandT, tvTypeEng, tvTypeUrdu, tvDetail;
    NetworkImageView ivCImage;
    private static ImageLoader imageLoader;
    FirebaseAnalytics mFBAnalytics;

    String complaintTypeList[] = {"Drainage", "Trash Bin", "Water Supply", "Garbage", "Other"};
    String complaintTypeListUrdu[] = {"نکاسی آب", "بھرا ہوا گند کا ڈھبہ", "پانی کا مسئلہ", "کوڑا کرکٹ", "کوئی اور مسئلہ"};

    String statusList[] = {"Pending Review", "In Progress", "Completed"};
    String statusListUrdu[] = {"زیر جائزہ", "کام جاری ہے", "مکمّل شدہ"};
    int colorList[] = {Color.RED, Color.parseColor("#ffc200"), Color.parseColor("#FF15762A")};

    public ComplaintDetailFragment() {
        // Required empty public constructor
    }

    public static ComplaintDetailFragment newInstance() {
        Bundle args = new Bundle();
        
        ComplaintDetailFragment fragment = new ComplaintDetailFragment();
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_complaint_detail, container, false);
        ivCImage = (NetworkImageView) view.findViewById(R.id.ivPreview);
        tvNo = (TextView) view.findViewById(R.id.tvCompNo);
        tvComplaintStatus = (TextView) view.findViewById(R.id.tvCompStatus);
        tvComplaintStatusUrdu = (TextView) view.findViewById(R.id.tvComplaintStatusUrdu);
        tvDandT = (TextView) view.findViewById(R.id.tvDandT);
        tvTypeEng = (TextView) view.findViewById(R.id.tvTypeEng);
        tvTypeUrdu = (TextView) view.findViewById(R.id.tvTypeUrdu);
        tvDetail = (TextView) view.findViewById(R.id.tvCompDetail);
        tvDetail.setMovementMethod(new ScrollingMovementMethod());

        mFBAnalytics = FirebaseAnalytics.getInstance(getContext());
        fbAnalytics();

        if (imageLoader == null)
            imageLoader = AppController.getInstance().getImageLoader();
        ivCImage.setImageUrl(getArguments().getString("C_IMAGE_URL"), imageLoader);
//        Glide.with(inflater.getContext()).load(getArguments().getString("C_IMAGE_URL")).override(300, 300).dontAnimate().into(ivCImage);
        tvNo.setText(getArguments().getString("C_NO"));
        tvDandT.setText(getArguments().getString("C_DATE_TIME"));
        tvTypeUrdu.setText(getArguments().getString("C_TYPE"));
        tvDetail.setText(getArguments().getString("C_DETAIL"));

        int i = 0;
        String status = getArguments().getString("C_STATUS");
        if (status.toLowerCase().contains("pendingreview")){
            i= 0;
        }else if (status.toLowerCase().contains("inprogress")){
            i= 1;
        }else if (status.toLowerCase().contains("completed")){
            i= 2;
        }
        tvComplaintStatus.setText(statusList[i]);
        tvComplaintStatusUrdu.setText(statusListUrdu[i]);
        tvComplaintStatus.setBackgroundColor(colorList[i]);
        tvComplaintStatusUrdu.setBackgroundColor(colorList[i]);

        String type = getArguments().getString("C_TYPE");
        tvTypeEng.setText(getArguments().getString("C_TYPE"));
        if (type.toLowerCase().contains("drainage")){
            tvTypeUrdu.setText(complaintTypeListUrdu[0]);
        }else if (type.toLowerCase().contains("trash")){
            tvTypeUrdu.setText(complaintTypeListUrdu[1]);
        }else if (type.toLowerCase().contains("water")){
            tvTypeUrdu.setText(complaintTypeListUrdu[2]);
        }else if (type.toLowerCase().contains("garbage")){
            tvTypeUrdu.setText(complaintTypeListUrdu[3]);
        }else if (type.toLowerCase().contains("other")){
            tvTypeUrdu.setText(complaintTypeListUrdu[4]);
        }
        return view;
    }

    public void fbAnalytics(){
        Bundle bundle = new Bundle();
        bundle.putString("complaint_number", getArguments().getString("C_NO"));
        mFBAnalytics.logEvent("my_complaints", bundle);
    }

}
