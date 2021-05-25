<template>
  <div>
    <div id="header" style="width: inherit;height: 10%;margin-right: 20px">
      <router-link  to="/"><span class="guide" style="font-size: 35px;font-family: Consolas">Art Store</span></router-link>
      &nbsp;&nbsp;
      <span style="font-style: italic;font-size: 20px;font-family: Consolas;margin-right: 30px">   Where you find GENIUS and EXTRAORDINARY</span>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <router-link class="guide" to="/Search">搜索</router-link>
      <span id="UserState" style="float: right"></span>
      <!--    <span v-if={{localStorage.getItem('userId')}}>-->
      <!--    </span>-->
    </div>
    <div align="center">
      <el-form :model="logInForm" status-icon :rules="rules" ref="logInForm" label-width="100px" class="logIn_container">
        <el-form-item label="用户名" prop="name" class="anitem">
          <el-input type="text" v-model="logInForm.name" auto-complete="off" placeholder="不得为空"></el-input>
        </el-form-item>

        <el-form-item label="密码" prop="password" class="anitem">
          <el-input type="password" v-model="logInForm.password" auto-complete="off" placeholder="不得为空" show-password></el-input>
        </el-form-item>


        <el-form-item >
          <el-button type="primary"  v-on:click="logIn('logInForm')" class="threebutton" plain>登录</el-button>
        </el-form-item>
        <el-form-item >
          <router-link to="/Register">
            <el-button type="primary"  class="threebutton" plain>没有账户，去注册</el-button>
          </router-link>
        </el-form-item>
      </el-form>

    </div>

  </div>
</template>

<script>
export default {
  name: "LogIn",
  data(){
    var validateusername = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入用户名'));
      }
      else {
        callback();
      }
    };

    var validatepassword = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入密码'));
      } else {
        callback();
      }
    };


    return{
      logInForm: {
        name: '',
        password: '',

      },
      rules:{
        name: [
          {validator: validateusername, trigger: 'blur'}
        ],
        password: [
          {validator: validatepassword, trigger: 'blur'}
        ],

      }
    }
  },
  methods:{
    logIn (formName){
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.$axios.post('logIn.php',this.$qs.stringify(
              {
                "name":this.logInForm.name,
                "password":this.logInForm.password,

              }

          )).then(
              resp =>{
                if(resp.data[0]=="1"){
                  alert("登录成功");
                  localStorage.setItem("userID",resp.data[1]["userID"]);
                  localStorage.setItem("name",resp.data[1]["name"]);
                  if(localStorage.getItem("pathBeforeLogInAndRegister")=="1"){
                    this.$router.push({"name":"HomePage"});
                  }
                  if(localStorage.getItem("pathBeforeLogInAndRegister")=="2"){
                    this.$router.push({"name":"ArtworkDisplay"});
                  }
                  if(localStorage.getItem("pathBeforeLogInAndRegister")=="3"){
                    this.$router.push({"name":"Search"});
                  }
                  //window.location.reload();
                }
                else{
                  alert("登录失败\n用户名或密码错误");
                }
                //this.$router.push({"name":"PersonalCollection"});
              });

        }
        else {

          return false;
        }
      });

    }

  }
}
</script>

<style scoped>
/*.logIn_container{*/
/*  margin-left: 0;*/
/*  margin-right: 0;*/
/*  padding: 0 0 0 0;*/
/*}*/

.anitem{
  width:30%;
  margin-left: auto;
  margin-right: auto;
}
.logIn_container{
  margin-top: 3%;
}

/*.threebutton{*/
/*  margin-left: auto;*/
/*  margin-right: auto;*/
/*}*/
</style>