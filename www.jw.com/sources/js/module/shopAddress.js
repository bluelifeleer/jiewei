$(function(){
  'use strict';
  $(document).on('pageInit','#page-shop-address',function(e,id,page){
    $('#picker').picker({
      toolbarTemplate:'<div class="block w100b h50 lh450 borb1 bcc1c1c1"><a href="javascript:void(0);" class="close-picker block flr w60 h30 lh30 borrad5 mart10 marr20 txac white bgCB1408 external">确定</a></div>',
      cols:[
        {
          textAlign:'center',
          values:['北京','天津','上海','重庆','深圳','河北','山西']
        },
        {
          textAlign:'center',
          values:['大兴','海淀','东城区','通州区','廊坊','石家庄','邢台','邯郸','保定','闸北','宝田区','太原','原平','忻州','运城','临汾']
        },
        {
          textAlign:'center',
          values:['旧宫镇','十字堡','小店','城北','襄汾','侯马','稷山']
        }
      ],
      cssClass:'shop-address-picker'
    });
  });
//
});
