<template>
<div>
  <div>
    <router-link  to="/"><span class="guide" style="font-size: 35px;font-family: Consolas">Art Store</span></router-link>
    &nbsp;&nbsp;
    <span style="font-style: italic;font-size: 20px;font-family: Consolas">   Where you find GENIUS and EXTRAORDINARY</span>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <span id="UserState" style="float: right"></span>
  </div>
  <div align="center">

  <select id="according">
    <option value="1">根据名称搜索</option>
    <option value="2">根据简介搜索</option>
    <option value="3">根据作者名搜索</option>
  </select>
    <input type="text" id="searchcontent" style="width: 600px;margin-left: 30px;margin-right: 5px;height: 30px">
    <button v-on:click="search" class="guide" style="height: 30px;margin-right: 20px">搜索</button>
    <select id="sort">
      <option value="1">结果按价格升序</option>
      <option value="2">结果按价格降序</option>
      <option value="3">结果按点击量升序</option>
      <option value="4">结果按点击量降序</option>
    </select>
  </div>
  <div id="lengthIndictor" align="center"></div>
  <div id="PageIndictor" align="center"></div>
  <div id="buttonShowHere" align="center"></div>
  <div id="searchresult" align="center"></div>
  <div style="margin-top: 80px"></div>
  <div style="width: 100%;height: 4%;position: fixed;bottom:0;background-color: black;color: white;float: left" align="center" >
    Pictures from author.maintained by chen zhong.All rights reserved.
  </div>
</div>
</template>

<script>
var numofonePage = 5;
var searchresultlength;
var searchresult;
export default {
name: "Search",
  mounted:function () {
  this.showUserState();
  },
  methods:{
  search(){
    var according = document.getElementById("according").value;
    var sort = document.getElementById("sort").value;
    var searchcontent = document.getElementById("searchcontent").value;
    // if(searchcontent==""){
    //   alert("请输入搜索内容");
    //   return;
    // }
    this.$axios.post('Search.php',this.$qs.stringify(
        {
          "according":according,
          "sort":sort,
          "searchcontent":searchcontent
        }

    )).then(
        resp =>{
          searchresult = resp.data;
          searchresultlength = searchresult[0];
          var totalPageNumber = 1;
          var auxiliary = numofonePage;
          while(auxiliary<searchresultlength){
            auxiliary+=numofonePage;
            totalPageNumber++;
          }
          localStorage.setItem("totalPageNumber",totalPageNumber);
          // alert(searchresultlength);
          // alert(localStorage.getItem("totalPageNumber"));
          localStorage.setItem("currentPageIndex","1");
          //this.showSearchResult();
          //this.showPageButton();
          this.showLength();
        }
    )
  },
    showLength(){
      if(searchresultlength==0){
        document.getElementById("lengthIndictor").innerHTML="未找到符合条件的艺术品";
        return;
      }
      document.getElementById("lengthIndictor").innerHTML = "为您找到"+searchresultlength+"个艺术品";
      this.showPageIndictor();
      this.showPageButton();
      this.showSearchResultAccordingToPage();
    },
  showPageIndictor(){
    document.getElementById("PageIndictor").innerHTML = "当前在第"+localStorage.getItem("currentPageIndex")+"页";
  },
    showPageButton(){
    // if(searchresultlength==0){
    //   document.getElementById("buttonShowHere").innerHTML="未找到符合条件的艺术品";
    //   return;
    // }
    document.getElementById("buttonShowHere").innerHTML="";
    // var lengthspecification = document.createElement("div");
    //   lengthspecification.innerHTML = "为您找到"+searchresultlength+"个结果";
    //   lengthspecification.style.marginBottom = "8px";
    //   document.getElementById("buttonShowHere").append(lengthspecification);
    var totalPageNumber = localStorage.getItem("totalPageNumber")*1;
    var beforePageButton = document.createElement("button");
    beforePageButton.innerHTML = "前一页";
    beforePageButton.addEventListener("click",this.clickBeforePageButton)
    document.getElementById("buttonShowHere").append(beforePageButton);
    for(var i = 1;i<=totalPageNumber;i++){
      var PageButton = document.createElement("button");
      PageButton.value = i;
      PageButton.innerHTML = i;
      PageButton.addEventListener("click",this.clickPageButton);
      document.getElementById("buttonShowHere").append(PageButton);

    }
      var nextPageButton = document.createElement("button");
      nextPageButton.innerHTML = "后一页";
      nextPageButton.addEventListener("click",this.clickNextPageButton);
      document.getElementById("buttonShowHere").append(nextPageButton);

    },
    clickBeforePageButton(){
    var currentIndex = localStorage.getItem("currentPageIndex")*1;
    if(currentIndex != 1){
      currentIndex = currentIndex - 1;
    }
      localStorage.setItem("currentPageIndex",currentIndex);
      this.showPageIndictor();
      this.showSearchResultAccordingToPage();
    },
    clickNextPageButton(){
      var currentIndex = localStorage.getItem("currentPageIndex")*1;
      var totalPage = localStorage.getItem("totalPageNumber")*1;
      if(currentIndex != totalPage){
        currentIndex = currentIndex + 1;
      }
      localStorage.setItem("currentPageIndex",currentIndex);
      this.showPageIndictor();
      this.showSearchResultAccordingToPage();
    },
    clickPageButton(){
        var currentIndex = event.target.value;
      localStorage.setItem("currentPageIndex",currentIndex);
      this.showPageIndictor();
      this.showSearchResultAccordingToPage();
    },
    showUserState(){
      document.getElementById("UserState").innerHTML = "";
      if(localStorage.getItem("userID")!="-1"){
        var span = document.createElement("span");
        span.innerHTML = localStorage.getItem("name");
        span.addEventListener("click",this.goPersonalCollection);
        span.addEventListener("mouseover",this.mouseOver);
        span.addEventListener("mouseout",this.mouseOut);
        span.style.marginRight = "8px;"
        document.getElementById("UserState").append(span);
        var button = document.createElement("button");
        button.innerHTML = "登出";
        button.style.backgroundColor="white";
        button.addEventListener("click",this.logOut);
        button.addEventListener("mouseover",this.mouseOver);
        button.addEventListener("mouseout",this.mouseOut);
        document.getElementById("UserState").append(button);
      }
      else{

        var logInButton = document.createElement("button");
        logInButton.innerHTML = "登录";
        logInButton.style.backgroundColor="white";
        logInButton.addEventListener("click",this.goLogIn);
        logInButton.addEventListener("mouseover",this.mouseOver);
        logInButton.addEventListener("mouseout",this.mouseOut);
        logInButton.style.marginRight = "8px";
        document.getElementById("UserState").append(logInButton);
        var registerbutton = document.createElement("button");
        registerbutton.innerHTML = "注册";
        registerbutton.style.backgroundColor="white";
        registerbutton.addEventListener("click",this.goRegister);
        registerbutton.addEventListener("mouseover",this.mouseOver);
        registerbutton.addEventListener("mouseout",this.mouseOut);
        document.getElementById("UserState").append(registerbutton);
      }
    },
    showSearchResultAccordingToPage(){
        document.getElementById("searchresult").innerHTML="";
        var currentPage = localStorage.getItem("currentPageIndex")*1;
        for(var i = ((currentPage-1)*numofonePage)+1;(i<=currentPage*numofonePage)&&(i<=searchresultlength);i++){
          var searchResultCard = document.createElement("div");
          var image = document.createElement("img");
          image.src = "images/"+searchresult[i]["imageFileName"];
          image.value = searchresult[i]["imageFileName"];
          image.style.width = "400px";
          image.style.height = "300px";

          // collectionCard.append(image);

          searchResultCard.innerHTML = "title:&nbsp;&nbsp;&nbsp;"+searchresult[i]["title"]+"<br>"
              +"artist:&nbsp;&nbsp;&nbsp;"+searchresult[i]["artist"]+"<br>"
              +"yearOfWork:&nbsp;&nbsp;&nbsp;"+searchresult[i]["yearOfWork"]+"<br>"
              +"genre:&nbsp;&nbsp;&nbsp;"+searchresult[i]["genre"]+"<br>"
              +"view:&nbsp;&nbsp;&nbsp;"+searchresult[i]["view"]+"<br>"
              +"width:&nbsp;&nbsp;&nbsp;"+searchresult[i]["width"]+"<br>"
              +"height:&nbsp;&nbsp;&nbsp;"+searchresult[i]["height"]+"<br>"
              +"price:&nbsp;&nbsp;&nbsp;"+searchresult[i]["price"]+"<br>"
              +"timeReleased:&nbsp;&nbsp;&nbsp;"+searchresult[i]["timeReleased"]+"<br>";
          searchResultCard.append(image);
          searchResultCard.style.border="solid";
          searchResultCard.id = searchresult[i]["artworkID"];
          searchResultCard.style.width = "600px";
          searchResultCard.style.height="500px";
          searchResultCard.style.backgroundColor="#ffffff";
          searchResultCard.style.borderColor="#EBEEF5";
          searchResultCard.style.marginBottom = "0";
          searchResultCard.style.marginTop="50px";
          searchResultCard.style.borderWidth="1px";
          searchResultCard.style.color = "#606266";
          searchResultCard.style.fontWeight = "500";
          searchResultCard.style.boxShadow= "0 2px 12px 0 rgb(0,0,0,0.1)";
          searchResultCard.style.borderRadius = "4px";
          searchResultCard.addEventListener("click", this.showDetails);
          var br = document.createElement("br");
          searchResultCard.append(br);

          //collectionCard.append(button);

          document.getElementById("searchresult").append(searchResultCard);

        }
    },
    showSearchResult(){
      document.getElementById("searchresult").innerHTML="";
      if(length==0){
        var div = document.createElement("div");
        div.innerHTML = "暂时没有符合条件的艺术品";
        document.getElementById("searchresult").append(div);
        return;
      }
      var lengthdiv = document.createElement("div");
      lengthdiv.innerHTML = "为您找到"+length+"个结果";
      lengthdiv.style.marginBottom = "20px";
      document.getElementById("searchresult").append(lengthdiv);
      for(var i=1;i<length;i++){
        var searchResultCard = document.createElement("div");
        var image = document.createElement("img");
        image.src = "images/"+searchresult[i]["imageFileName"];
        image.value = searchresult[i]["imageFileName"];
        image.style.width = "400px";
        image.style.height = "300px";

        // collectionCard.append(image);

        searchResultCard.innerHTML = "title:&nbsp;&nbsp;&nbsp;"+searchresult[i]["title"]+"<br>"
            +"artist:&nbsp;&nbsp;&nbsp;"+searchresult[i]["artist"]+"<br>"
            +"yearOfWork:&nbsp;&nbsp;&nbsp;"+searchresult[i]["yearOfWork"]+"<br>"
            +"genre:&nbsp;&nbsp;&nbsp;"+searchresult[i]["genre"]+"<br>"
            +"view:&nbsp;&nbsp;&nbsp;"+searchresult[i]["view"]+"<br>"
            +"width:&nbsp;&nbsp;&nbsp;"+searchresult[i]["width"]+"<br>"
            +"height:&nbsp;&nbsp;&nbsp;"+searchresult[i]["height"]+"<br>"
            +"price:&nbsp;&nbsp;&nbsp;"+searchresult[i]["price"]+"<br>"
            +"timeReleased:&nbsp;&nbsp;&nbsp;"+searchresult[i]["timeReleased"]+"<br>";
        searchResultCard.append(image);
        searchResultCard.style.border="solid";
        searchResultCard.id = searchresult[i]["artworkID"];
        searchResultCard.style.width = "600px";
        searchResultCard.style.height="500px";
        searchResultCard.style.backgroundColor="#ffffff";
        searchResultCard.style.borderColor="#EBEEF5";
        searchResultCard.style.marginBottom = "0";
        searchResultCard.style.marginTop="50px";
        searchResultCard.style.borderWidth="1px";
        searchResultCard.style.color = "#606266";
        searchResultCard.style.fontWeight = "500";
        searchResultCard.style.boxShadow= "0 2px 12px 0 rgb(0,0,0,0.1)";
        searchResultCard.style.borderRadius = "4px";
        searchResultCard.addEventListener("click", this.showDetails);
        var br = document.createElement("br");
        searchResultCard.append(br);

        //collectionCard.append(button);

        document.getElementById("searchresult").append(searchResultCard);
        // var button = document.createElement("button");
        // button.innerHTML = "删除";
        // button.id = searchresult[i]["imageFileName"];
        // button.addEventListener("click",this.dropCollection);
        //
        // document.getElementById("information").append(button);
      }


    },
    showDetails(){
      var artworkID = event.target.id;
      if(artworkID == ""){
        var value = event.target.value;
        artworkID = value.split(".")[0];
      }
      // var value = document.getElementById(id).value;
      // var artworkID = id.split(".")[0];
      localStorage.setItem("artworkID",artworkID);
      this.$router.push({"name":"ArtworkDisplay"});
    },
    goPersonalCollection(){
      this.$router.push({"name":"PersonalCollection"});
    }
    ,
    goRegister() {
      localStorage.setItem("pathBeforeLogInAndRegister","3");
      this.$router.push({"name":"Register"});
      //HomePage为1，ArtworkDisplay为2，Search为3
    },
    goLogIn(){
      localStorage.setItem("pathBeforeLogInAndRegister","3");
      this.$router.push({"name":"LogIn"});
    },
    logOut(){
      var sure = confirm("确定要登出吗");
      if(sure==true){
        localStorage.setItem("userID","-1");
        localStorage.setItem("name","-1");
        this.showUserState();
      }


    },
    mouseOver(){
      event.target.style.backgroundColor = "yellow";
      event.target.style.cursor="pointer";
    },
    mouseOut(){
      event.target.style.backgroundColor = "white";
      event.target.style.cursor="default";
    },
  }
}
</script>

<style scoped>
.guide:hover{background-color:yellow;cursor: pointer}
</style>