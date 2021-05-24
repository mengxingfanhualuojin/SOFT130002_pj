<template>
  <div>
  <div id="header" style="width: inherit;height: 10%;margin-right: 20px">
    <router-link  to="/"><span class="guide" style="font-size: 35px;font-family: Consolas">Art Store</span></router-link>
    &nbsp;&nbsp;
    <span style="font-style: italic;font-size: 20px;font-family: Consolas;margin-right: 30px">   Where you find GENIUS and EXTRAORDINARY</span>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <router-link class="guide" to="/Search">搜索</router-link>
    <router-link to="/PersonalCollection"><span class="guide" style="float: right">master</span></router-link>

  </div>
  <hr>
  <div style="width: 100%;height: 15%" align="center">
    <span id="title" style="font-weight: bold;font-size: 15px"></span>
    <br>
    <span id="artist" class="guide" style="font-size: 12px"></span>
  </div>
  <hr>
  <div style="width: 60%;height: 40%;margin-top: 4%;float: left" align="center" >
    <img id="image" src="" width="500" height="400">
  </div>

  <div id="describebody" style="width: 40%;height: 40%;margin-top: 10%;float: left" align="center" >
    <!--    <div id="description" style="font-size: 10px;width: 400px;height: 250px;overflow: scroll"></div>-->
    <span id="yearOfWork" style="font-size: 16px"></span>
    <br><br>
    <span id="genre" style="font-size: 16px"></span>
    <br><br>
    <span id="width" style="font-size: 16px"></span>
    <br><br>
    <span id="height" style="font-size: 16px"></span>
    <br><br>
    <span id="price" style="font-size: 16px"></span>
    <br>
    <br>
    <span id="view" style="font-size: 16px"></span>
    <br><br>
    <span id="isCollected" style="font-size: 16px"></span>
    <!--    <button type="button" class="guide" onclick="collect_alert()">收藏</button>-->

  </div>

  <div style="width: 100%;height: 4%;position: fixed;bottom:0;background-color: black;color: white;float: left;margin-top: 108px" align="center" >
    Pictures from author.maintained by chen zhong.All rights reserved.
  </div>
  </div>
</template>

<script>
var details;
export default {
  name: "ArtworkDisplay",
  mounted: function () {
    this.getInformationAndShow();

  },
  methods: {
    getInformationAndShow() {
      this.$axios.post('GetSpecificArtwork.php', this.$qs.stringify(
          {
            "artworkID": localStorage.getItem("artworkID")
          }
      )).then(
          resp => {
            details = resp.data;
            this.showInformation();
          }
      )
    },
    showInformation() {
      document.getElementById("title").innerHTML = details[0]["title"];
      document.getElementById("artist").innerHTML = details[0]["artist"];
      document.getElementById("image").src = "images/" + details[0]["imageFileName"];
      // document.getElementById("description").innerHTML=description;
      document.getElementById("yearOfWork").innerHTML = "yearOfWork:&nbsp;&nbsp;" + details[0]["yearOfWork"];
      document.getElementById("genre").innerHTML = "genre:&nbsp;&nbsp;" + details[0]["genre"];
      document.getElementById("width").innerHTML = "width:&nbsp;&nbsp;" + details[0]["width"];
      document.getElementById("height").innerHTML = "height:&nbsp;&nbsp;" + details[0]["height"];
      document.getElementById("price").innerHTML = "price:&nbsp;&nbsp;" + details[0]["price"];
      document.getElementById("view").innerHTML = "view:&nbsp;&nbsp;" + details[0]["view"];
      var iscollected = details[1];
      if (iscollected == "1") {
        var uncollectbutton = document.createElement("button");
        uncollectbutton.id = "collectButton";
        uncollectbutton.innerHTML = "取消收藏";
        uncollectbutton.style.backgroundColor = "white";
        uncollectbutton.addEventListener("click", this.dropCollection);
        uncollectbutton.addEventListener("mouseover", function () {
          uncollectbutton.style.backgroundColor = "yellow";
          uncollectbutton.style.cursor = "pointer";
        });
        uncollectbutton.addEventListener("mouseout", function () {
          uncollectbutton.style.backgroundColor = "white";
          uncollectbutton.style.cursor = "default";
        });
        document.getElementById("describebody").append(uncollectbutton);
      }
      if (iscollected == "0") {
        var button = document.createElement("button");
        button.id = "collectButton";
        button.innerHTML = "收藏";
        button.style.backgroundColor = "white";
        button.addEventListener("click", this.collect);
        button.addEventListener("mouseover", function () {
          button.style.backgroundColor = "yellow";
          button.style.cursor = "pointer";
        });
        button.addEventListener("mouseout", function () {
          button.style.backgroundColor = "white";
          button.style.cursor = "default";
        });
        document.getElementById("describebody").append(button);
      }
    },
    collect() {
      this.$axios.post('/CollectSpecificArtwork.php', this.$qs.stringify(
          {
            "artworkID": localStorage.getItem("artworkID")
          })).then(
          resp => {
            if (resp.data == "1") {
              alert("收藏成功");
              window.location.reload();
            } else {
              alert("收藏失败");
              window.location.reload();
            }
          }
      )
    },
    dropCollection() {
        this.$axios.post('UnCollectSpecificArtwork.php', this.$qs.stringify(
            {
              "userID": 1,
              "artworkID": localStorage.getItem("artworkID")
            }
        )).then(
            resp => {
              if (resp.data == "1") {
                alert("取消收藏成功");
                window.location.reload();
              } else {
                alert("取消收藏失败");
                window.location.reload();
              }
              //this.$router.push({"name":"PersonalCollection"});
            });

    }
  }
}
</script>

<style scoped>
.guide:hover{background-color:yellow}
img:hover{
  transform: scale(1.2);
}
</style>