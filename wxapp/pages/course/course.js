var server = wx.getStorageSync('server');
Page({
  data: {
    course:[],
    check:0,
    colorArrays: ["#85B8CF", "#90C652", "#D8AA5A", "#FC9F9D", "#0A9A84", "#61BC69", "#12AEF3", "#E29AAD"],
  },

  onLoad: function () {
    var that = this;
    wx.request({
      url: 'https://' + server + '/wSicau/public/index.php/index/Course/index',
      data: { openId: wx.getStorageSync('user') },
      method:'POST',
      success:function(res){
        that.setData({
          course:res.data,
          check:1
        });
      }
    })
  }

})