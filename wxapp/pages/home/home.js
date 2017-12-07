// home.js

var server = wx.getStorageSync('server');

Page({

  /**
   * 页面的初始数据
   */
  data: {
    month:{},
    week:{},
    weekDay:{},
    course:[],
    notice:[],
    checkData:0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function () {
    var that = this;
    //获取页面数据
    wx.request({
      url: 'https://' + server + '/wSicau/public/index.php/index/Home/index',
      data:{openId:wx.getStorageSync('user')},
      method:'POST',
      success:function(res){
        var data = res.data;
        var date = new Date;
        var month = date.getMonth() + 1;
        var day = date.getDate();
        that.setData({
          month: month + '月' + day + '日',
          week: data.weekNum,
          weekDay: data.weekDay,
          course: data.todayCourse,
          notice: data.notice,
          check:1
        })
      }
    })
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