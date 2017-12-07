// my.js
var app = getApp();
var server = wx.getStorageSync('server');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    stuData:{},
    imgPath:{},
    check:0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    //调用应用实例的方法获取全局数据
   wx.request({
     url:'https://' + server + '/wSicau/public/index.php/index/My/index',
     data:{openId:wx.getStorageSync('user')},
     method:'POST',
     success:function(res){
       that.setData({
         stuData:res.data,
         imgPath:'http://jiaowu.sicau.edu.cn/photo/'+res.data.num+'.jpg',
         check:1
       })
     }
   });
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})