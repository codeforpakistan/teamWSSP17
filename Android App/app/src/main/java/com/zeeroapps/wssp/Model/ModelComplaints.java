package com.zeeroapps.wssp.Model;

import com.zeeroapps.wssp.utils.Constants;

/**
 * Created by fazalullah on 4/17/17.
 */

public class ModelComplaints {
    private String cNumber;
    private String cType;
    private String cDetail;
    private String cAddress;
    private String cStatus;
    private String cImageUrl;
    private String cDateAndTime;

    public void setcNumber(String cNumber) {
        this.cNumber = cNumber;
    }

    public void setcStatus(String cStatus) {
        this.cStatus = cStatus;
    }

    public void setcImageUrl(String cImageUrl) {
        this.cImageUrl = Constants.HOST_URL+cImageUrl;
    }

    public void setcDateAndTime(String cDateAndTime) {
        this.cDateAndTime = cDateAndTime;
    }

    public void setcType(String cType) {
        this.cType = cType;
    }

    public void setcAddress(String cAddress) {
        this.cAddress = cAddress;
    }

    public void setcDetail(String cDetail) {
        this.cDetail = cDetail;
    }

    public String getcNumber() {
        return cNumber;
    }

    public String getcStatus() {
        return cStatus;
    }

    public String getcImageUrl() {
        return cImageUrl;
    }

    public String getcDateAndTime() {
        return cDateAndTime;
    }

    public String getcType() {
        return cType;
    }

    public String getcAddress() {
        return cAddress;
    }

    public String getcDetail() {
        return cDetail;
    }
}
