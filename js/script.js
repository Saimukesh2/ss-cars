$(".parent input").on('click',function(){ 
  var _parent=$(this);
  var nextli=$(this).parent().next().children().children();
  
  if(_parent.prop('checked')){
     console.log('parent checked');
     nextli.each(function(){
       $(this).children().prop('checked',true);
     });
    
  }
  else{
    console.log('parent un checked');
     nextli.each(function(){
       $(this).children().prop('checked',false);
     });
  
  }
});

$(".child input").on('click',function(){ 
  var ths=$(this);
  var parentinput=ths.closest('div').prev().children();
   var childinput=ths.children('div').next().children();
  //alert(parentinput);
  var sibblingsli=ths.closest('ul').find('li');
 // var mainparent=parentinput.closest('div').prev().children();
  if(ths.prop('checked')){
    console.log('child checked');
    parentinput.prop('checked',true);
    sibblingsli.prop('checked',true);
    childinput.prop('checked',true);
    $('.collapse').show();
 //   mainparent.prop('checked',true);
  }
  else{
    console.log('child unchecked');
       var status=true;
     sibblingsli.each(function(){
       console.log('sibb');
       if($(this).children().prop('checked')) status=false;
     });
       if(status) parentinput.prop('checked',false);
  }
});