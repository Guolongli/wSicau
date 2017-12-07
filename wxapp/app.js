var util = require('/utils/util.js')
//app.js
App({
  onLaunch: function () {
    wx.setStorageSync('server', 'www.haizhilongli.com')
    //调用API从本地缓存中获取数据
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)
  },
  getUserInfo:function(cb){
    var that = this
    if(this.globalData.userInfo){
      typeof cb == "function" && cb(this.globalData.userInfo)
    }else{
      //调用登录接口
      wx.login({
        success: function (res) {
          wx.getUserInfo({
            success: function (res) {
              that.globalData.userInfo = res.userInfo
              typeof cb == "function" && cb(that.globalData.userInfo)
              var objz={}
              objz.avatarUrl = res.userInfo.avatarUrl
              objz.nickName = res.userInfo.nickName
            }
          })
          //获取用户的openid
          wx.request({
            url: 'https://www.haizhilongli.com/wSicau/public/index.php/index/index/getOpenId',
            data: { code: res.code },
            method:'POST',
            success: function (r) {
              wx.setStorageSync('user', r.data);
            }
          });
        }
      })
    }
  },
  globalData:{
    userInfo:null,
  }
})