<template>
  <div>
  <div id="header" style="width: inherit;height: 10%;margin-right: 20px">
    <span style="font-size: 50px;font-family: Consolas">Art Store</span>
    &nbsp;
    <span style="font-style: italic;font-size: 20px;font-family: Consolas">   Where you find GENIUS and EXTRAORDINARY</span>
    <span style="margin-top:15px;float: right">
      <router-link class="guide" to="/">首页</router-link>
      &nbsp;&nbsp;&nbsp;
      <router-link class="guide" to="/Search">搜索</router-link>
      &nbsp;&nbsp;&nbsp;
<!--      <router-link class="guide" to="/PersonalCollection">个人收藏</router-link>-->

      <span id="UserState"></span>
</span>
  </div>

  <hr>
  <div align="center">
    <img id="toppicture" v-on:click="showDetails" src="" height="240" width="1024" >
    <div style="float: left;margin-bottom: 0px;width: 400px">
      <p id="toptitle" style="margin-bottom: 0px"></p>
      <p >简介：</p>
      <div id="topdescription" style="overflow: scroll;height: 150px"></div></div>

  </div>
  <hr>
  <div style="width: 30%;height: 40%;margin-left: 1%;float: left;" align="center">
    <img id="newimg1" src="" height="125" width="300">
    <br>
    <span id="newTitle1" style="font-size: 15px"></span>
    <br>
    <span id="newArtist1" style="font-size: 12px;font-style: italic"></span>
    <br>
    <div id="newDescription1" style="font-size: 10px;width: 270px;height: 100px;overflow: scroll"></div>
    <br>
    <a class="guide" id="newa1" v-on:click="showDetails">Learn More</a>
  </div>
  <div style="width: 30%;height: 40%;margin-left: 3%;float: left;" align="center">
    <img id="newimg2" src="" height="125" width="300">
    <br>
    <span id="newTitle2" style="font-size: 15px"></span>
    <br>
    <span id="newArtist2" style="font-size: 12px;font-style: italic"></span>
    <br>
    <div id="newDescription2" style="font-size: 10px;width: 270px;height: 100px;overflow: scroll"></div>
    <br>
    <a class="guide" id="newa2" v-on:click="showDetails">Learn More</a>
  </div>
  <div style="width: 30%;height: 40%;margin-left: 3%;float: left;" align="center">
    <img id="newimg3" src="" height="125" width="300">
    <br>
    <span id="newTitle3" style="font-size: 15px"></span>
    <br>
    <span id="newArtist3" style="font-size: 12px;font-style: italic"></span>
    <br>
    <div id="newDescription3" style="font-size: 10px;width: 270px;height: 100px;overflow: scroll"></div>
    <br>
    <a class="guide" id="newa3" v-on:click="showDetails">Learn More</a>
  </div>

  <div style="position:fixed;bottom:0;width: 100%;height: 4%;background-color: black;color: white;float: left" align="center" >
    Pictures from author.maintained by chen zhong.All rights reserved.
  </div>
  </div>
</template>

<script>
var topartworks;
var newestartworks;
var topIndex = 0;
var timedevents;
export default {
  name: "HomePage",
  mounted: function () {
    this.initialuserID();
    this.getInformationAndShow();
    this.showUserState();

  },
  beforeRouteLeave(to,from,next){
    window.clearInterval(timedevents);
    next();

  },
  methods:{
    initialuserID(){
      if(localStorage.getItem("userID") == null){
        localStorage.setItem("userID","-1");

      }

    },
    // show(){
    //   this.$axios.post("/GetTopArtworks.php",this.$qs.stringify({
    //     "hello":"hello PHP"
    //   })).then(
    //       resp=>{
    //         console.log(resp.data);
    //         alert(resp.data["title"])
    //       }
    //   )
    // }
    changetop(){
      document.getElementById("toppicture").src = "images/"+topartworks[topIndex]["imageFileName"];
      document.getElementById("toppicture").value = topartworks[topIndex]["imageFileName"];
      document.getElementById("toptitle").innerHTML = "Title:&nbsp;&nbsp;&nbsp;&nbsp;"+topartworks[topIndex]["title"];
      document.getElementById("topdescription").innerHTML = topartworks[topIndex]["description"];
      topIndex = (topIndex+1)%3;
    },
    shownewest(){
      document.getElementById("newimg1").src = "images/"+newestartworks[0]["imageFileName"];
      document.getElementById("newTitle1").innerHTML = newestartworks[0]["title"];
      document.getElementById("newArtist1").innerHTML = newestartworks[0]["artist"];
      document.getElementById("newDescription1").innerHTML = newestartworks[0]["description"];
      document.getElementById("newa1").value = newestartworks[0]["imageFileName"];

      document.getElementById("newimg2").src = "images/"+newestartworks[1]["imageFileName"];
      document.getElementById("newTitle2").innerHTML = newestartworks[1]["title"];
      document.getElementById("newArtist2").innerHTML = newestartworks[1]["artist"];
      document.getElementById("newDescription2").innerHTML = newestartworks[1]["description"];
      document.getElementById("newa2").value = newestartworks[1]["imageFileName"];

      document.getElementById("newimg3").src = "images/"+newestartworks[2]["imageFileName"];
      document.getElementById("newTitle3").innerHTML = newestartworks[2]["title"];
      document.getElementById("newArtist3").innerHTML = newestartworks[2]["artist"];
      document.getElementById("newDescription3").innerHTML = newestartworks[2]["description"];
      document.getElementById("newa3").value = newestartworks[2]["imageFileName"];

    },
    getInformationAndShow(){
      this.$axios.get("/GetTopArtworks.php").then(
        resp => {
          topartworks = resp.data;
          this.changetop();
          timedevents=window.setInterval(this.changetop,3000);
      }
      );
      this.$axios.get('/GetNewestArtworks.php').then(
          resp=>{
            newestartworks = resp.data;
            this.shownewest();
          }
      );




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
    goPersonalCollection(){
      this.$router.push({"name":"PersonalCollection"});
    }
  ,
    goRegister() {
      localStorage.setItem("pathBeforeLogInAndRegister","1");
      this.$router.push({"name":"Register"});
      //HomePage为1，ArtworkDisplay为2，Search为3
    },
    goLogIn(){
      localStorage.setItem("pathBeforeLogInAndRegister","1");
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
    showDetails(){
      var id = event.target.id;
      var value = document.getElementById(id).value;
      var artworkID = value.split(".")[0];
      localStorage.setItem("artworkID",artworkID);
      // window.clearInterval(timedevents);
      this.$router.push({"name":"ArtworkDisplay"});
    }

  }

}
</script>

<style scoped>
.guide:hover{
  background-color:yellow;
  cursor: pointer;
}
#toppicture:hover{
  cursor: pointer;
}
</style>