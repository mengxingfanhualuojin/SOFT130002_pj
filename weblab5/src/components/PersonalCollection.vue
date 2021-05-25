<template><div>
  <div>
    <router-link  to="/"><span class="guide" style="font-size: 35px;font-family: Consolas">Art Store</span></router-link>
    &nbsp;&nbsp;
    <span style="font-style: italic;font-size: 20px;font-family: Consolas;margin-right: 20px">   Where you find GENIUS and EXTRAORDINARY</span>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <router-link class="guide" to="/Search">搜索</router-link>
    <el-button style="float: right" v-on:click="logOut">登出</el-button>
  </div>
<div id="information" align="center">

</div>
  <div style="margin-top: 80px"></div>
    <div style="width: 100%;height: 4%;position: fixed;bottom:0;background-color: black;color: white;float: left;margin-top: 108px" align="center" >
      Pictures from author.maintained by chen zhong.All rights reserved.
    </div>
  </div>
</template>

<script>
var information;
export default {
name: "PersonalCollection",
  mounted: function () {
    this.getInformationAndShow();

  },
  methods:{
    getInformationAndShow(){
      if(localStorage.getItem("userID")=="-1"){
        return;
      }
      this.$axios.post('GetPersonalAndCollectionInformation.php',this.$qs.stringify(
          {
            "userID":localStorage.getItem("userID")
          }

      )).then(
          resp =>{
            information = resp.data;
            this.showInformation();
          }
      )
    },
    showInformation() {
      var length = information.length;
      var personalInformationCard = document.createElement("div");

      personalInformationCard.innerHTML = "name:&nbsp;&nbsp;&nbsp;"+information[0]["name"]+"<br>"
      +"email:&nbsp;&nbsp;&nbsp;"+information[0]["email"]+"<br>"
      +"tel:&nbsp;&nbsp;&nbsp;"+information[0]["tel"]+"<br>"
      +"address:&nbsp;&nbsp;&nbsp;"+information[0]["address"]+"<br>"
      +"balance:&nbsp;&nbsp;&nbsp;"+information[0]["balance"]+"<br>";
      personalInformationCard.style.border="solid";
      personalInformationCard.style.width = "600px";
      personalInformationCard.style.height="100px";
      personalInformationCard.style.backgroundColor="#ffffff";
      personalInformationCard.style.borderColor="#EBEEF5";
      personalInformationCard.style.marginBottom = "30px";
      personalInformationCard.style.borderWidth="1px";
      personalInformationCard.style.color = "#606266";
      personalInformationCard.align = "center";
      personalInformationCard.style.alignItems = "center";
      personalInformationCard.style.fontWeight = "500";
      personalInformationCard.style.boxShadow= "0 2px 12px 0 rgb(0,0,0,0.1)";
      personalInformationCard.style.borderRadius = "4px";
      document.getElementById("information").append(personalInformationCard);

      if(length==1){
        var div = document.createElement("div");
        div.innerHTML = "暂无收藏";
        document.getElementById("information").append(div);
        return;
      }
      for(var i=1;i<length;i++){
        var collectionCard = document.createElement("div");
        var image = document.createElement("img");
        image.src = "images/"+information[i]["imageFileName"];
        image.style.width = "400px";
        image.value = information[i]["imageFileName"];
        image.style.height = "300px";

        // collectionCard.append(image);

        collectionCard.innerHTML = "title:&nbsp;&nbsp;&nbsp;"+information[i]["title"]+"<br>"
            +"artist:&nbsp;&nbsp;&nbsp;"+information[i]["artist"]+"<br>"
            +"yearOfWork:&nbsp;&nbsp;&nbsp;"+information[i]["yearOfWork"]+"<br>"
            +"genre:&nbsp;&nbsp;&nbsp;"+information[i]["genre"]+"<br>"
            +"view:&nbsp;&nbsp;&nbsp;"+information[i]["view"]+"<br>"
            +"width:&nbsp;&nbsp;&nbsp;"+information[i]["width"]+"<br>"
            +"height:&nbsp;&nbsp;&nbsp;"+information[i]["height"]+"<br>"
            +"price:&nbsp;&nbsp;&nbsp;"+information[i]["price"]+"<br>"
            +"timeReleased:&nbsp;&nbsp;&nbsp;"+information[i]["timeReleased"]+"<br>";
        collectionCard.append(image);
        collectionCard.style.border="solid";
        collectionCard.id = information[i]["artworkID"];
        collectionCard.style.width = "600px";
        collectionCard.style.height="500px";
        collectionCard.style.backgroundColor="#ffffff";
        collectionCard.style.borderColor="#EBEEF5";
        collectionCard.style.marginBottom = "0";
        collectionCard.style.marginTop="50px";
        collectionCard.style.borderWidth="1px";
        collectionCard.style.color = "#606266";
        collectionCard.style.fontWeight = "500";
        collectionCard.style.boxShadow= "0 2px 12px 0 rgb(0,0,0,0.1)";
        collectionCard.style.borderRadius = "4px";
        collectionCard.addEventListener("click", this.showDetails);
        var br = document.createElement("br");
        collectionCard.append(br);

        //collectionCard.append(button);

        document.getElementById("information").append(collectionCard);
        var button = document.createElement("button");
        button.innerHTML = "删除";
        button.id = information[i]["imageFileName"];
        button.style.backgroundColor="white";
        button.addEventListener("mouseover",this.deleteMouseOver);
        button.addEventListener("mouseout",this.deleteMouseOut);
        button.addEventListener("click",this.dropCollection);

        document.getElementById("information").append(button);
      }

    },
    logOut(){
      var sure = confirm("确定要登出吗");
      if(sure==true){
        localStorage.setItem("userID","-1");
        localStorage.setItem("name","-1");
        this.$router.push({"name":"HomePage"});
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
    dropCollection(){
      var id = event.target.id;
      var artworkID = id.split(".")[0];
      var sure = confirm("确定要删除此艺术品吗？");
      if(sure==true){
        this.$axios.post('UnCollectSpecificArtwork.php',this.$qs.stringify(
            {
              "userID":localStorage.getItem("userID"),
              "artworkID":artworkID
            }

        )).then(
            resp =>{
              if(resp.data=="1"){
                alert("删除成功");
                window.location.reload();
              }
              else{
                alert("删除失败");
              }
              //this.$router.push({"name":"PersonalCollection"});
            });

      }

    },
    deleteMouseOver(){
      var id = event.target.id;
      document.getElementById(id).style.backgroundColor = "yellow";
      document.getElementById(id).style.cursor="pointer";
    },
    deleteMouseOut(){
      var id = event.target.id;
      document.getElementById(id).style.backgroundColor = "white";
      document.getElementById(id).style.cursor="default";
    }
  }
}
</script>

<style scoped>
.guide:hover{background-color:yellow}
.show{
  border:2px solid;
  border-color: aqua;
}
</style>