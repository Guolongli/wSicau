var util = require('../../utils/util.js');
//index.js
//获取应用实例
var app = getApp()
var server = wx.getStorageSync('server')

Page({
  data: {
    motto: '欢迎来到川农微教务，点击头像进入系统',
    userInfo: {}
  },
  //事件处理函数
  bindViewTap: function() {
    wx.switchTab({
      url: '../home/home'
    })
  },
  onLoad: function () {
    //console.log('onLoad')
    var that = this
    //调用应用实例的方法获取全局数据
    app.getUserInfo(function(userInfo){
      //更新数据
      that.setData({
        userInfo:userInfo
      })
    })
    //获取user openid
    var userOpenid = wx.getStorageSync('user')

    //向服务器发送请求，进行用户数据验证
    wx.request({
      url: 'https://' + server + '/wSicau/public/index.php',
      data: { openId: userOpenid },
      method: 'POST',
      success: function (res) {
        var userCheck = res.data.code;
        if (userCheck == 1) {
          //console.log('我准备跳转了')
          wx.showToast({
            title: '正在跳转',
            icon : 'loading',
            duration : 3000
          })
          setTimeout(function(){
            wx.switchTab({
              url: '../home/home'
            })
          },3000)
        }
      }
    })
  },
  //表单提交
  formSubmit:function(e){
    var that = this;
    var formData = e.detail.value;
    //console.log(formData);
    //向服务器发送请求
    wx.request({
      url: 'https://' + server + '/wSicau/public/index.php/index/Index/login',
      data:{user:formData.user,password:formData.password,openId:wx.getStorageSync('user')},
      method:'POST',
      success:function(res){
        var code = res.data.code;
        //console.log(res.data);
        if(code == 1){
          wx.showToast({
            title: res.data.message,
            icon:'success',
            duration : 1000
          });
          wx.switchTab({
            url: '../home/home',
          })
        }else{
          wx.showModal({
            title: '',
            content: res.data.message,
          })
        }
      }
    })
  }
})
