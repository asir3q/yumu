  // 全站通用js
  function $(name) {
    return document.querySelector(name);
  }
  
  function addloadEvent(func) {
    let oldonload = window.onload;
    "function" != typeof window.onload
      ? (window.onload = func)
      : (window.onload = function () {
          oldonload && oldonload(), func();
        });
  }
  function goTopbtn() {
    let gotop = $("goTop"),timer,tf = !0;
    (window.onscroll = function () {
      let ostop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop,ch = document.documentElement.clientHeight || document.body.clientHeight;
      (goTop.style.display = ostop >= ch ? "block" : "none"),tf || clearInterval(timer),(tf = !1);
    }),(goTop.onclick = function () {document.body.scrollIntoView();
    });
  }
  addloadEvent(goTopbtn)
  let has_children=document.getElementsByClassName("menu-item-has-children");
	for(i=0;i<has_children.length;i++){
    has_children[i].getElementsByTagName("a")[0].insertAdjacentHTML('afterend','<span class="menu-sign"></span>');
  }
  $(".goFind").onclick = function(){
    $(".site-search").classList.toggle("none"),
    $(".field").focus()
  },$(".closeFind").onclick = function(){
    $(".site-search").classList.toggle("none")
  },$(".field").onblur = function(){
    $(".site-search").classList.toggle("none")
  },$(".openMenu").onclick = function(){
    $(".header-menu").classList.toggle("open-header-menu"),
    $(".mask").style.display = "block";
  },$(".closeMenu").onclick = function(){
    $(".header-menu").classList.toggle("open-header-menu"),
    $(".mask").style.display = "none";
  },$(".mask").onclick = function(){
    $(".header-menu").classList.toggle("open-header-menu"),
    $(".mask").style.display = "none";
  }
  !$(".post-navigation") || ($(".nav_box_previous") && $(".nav_box_next")) || ($(".nav-box").style.width = "100%");
  
  //移动端打开或关闭二级菜单
  if(document.body.scrollWidth<767){
    var oldIndex = '',classIndex = '',menu_has_children = document.getElementsByClassName('menu-item-has-children'),menu_sign = document.getElementsByClassName('menu-sign');
    for(var i=0;i<menu_sign.length;i++){
      menu_sign[i].setAttribute("index",i),
      menu_sign[i].onclick = function(){
        classIndex = this.getAttribute("index");
        if(oldIndex!=''&&oldIndex!=classIndex){
          menu_sign[oldIndex].classList.remove("open-menu-sign"),
          menu_has_children[oldIndex].classList.remove("open-menu-item-has-children");
        }
        menu_sign[classIndex].classList.toggle("open-menu-sign"),
        menu_has_children[classIndex].classList.toggle("open-menu-item-has-children");
        oldIndex = classIndex;
      }
    };
    document.addEventListener('click', function(event) {
        if(oldIndex!=''){
          if (event.target !== menu_sign[oldIndex]) {
            menu_sign[oldIndex].classList.remove("open-menu-sign"),
            menu_has_children[oldIndex].classList.remove("open-menu-item-has-children");
            oldIndex='';
          }
        }
    });
  }
  //切换暗黑模式
  function setDark() {
    localStorage.setItem("isDarkMode", "1");
    document.documentElement.classList.add("dark");
  }
  function removeDark() {
    localStorage.setItem("isDarkMode", "0");
    document.documentElement.classList.remove("dark");
  }
  function switchDarkMode() {
    let isDark = localStorage.getItem("isDarkMode");
    if (isDark == "1") {
      removeDark();
    } else {
      setDark();
    }
  }
