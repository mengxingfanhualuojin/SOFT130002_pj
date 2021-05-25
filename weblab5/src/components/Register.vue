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
    <el-form :model="registerForm" status-icon :rules="rules" ref="registerForm" label-width="100px" class="register_container">
      <el-form-item label="用户名" prop="name" class="anitem">
        <el-input type="text" v-model="registerForm.name" auto-complete="off" placeholder="不得为空"></el-input>
      </el-form-item>

      <el-form-item label="密码" prop="password" class="anitem">
        <el-input type="password" v-model="registerForm.password" auto-complete="off" placeholder="需同时包含字母和数字" show-password></el-input>
      </el-form-item>

      <el-form-item label="确认密码" prop="checkpassword" class="anitem">
        <el-input type="password" v-model="registerForm.checkpassword" auto-complete="off" placeholder="与密码一致" show-password></el-input>
      </el-form-item>

      <el-form-item label="电子邮件" prop="email" class="anitem">
        <el-input type="text" v-model="registerForm.email" auto-complete="off" placeholder="不得为空"></el-input>
      </el-form-item>

      <el-form-item label="电话" prop="tel" class="anitem">
        <el-input type="text" v-model="registerForm.tel" auto-complete="off" placeholder="不得为空"></el-input>
      </el-form-item>

      <el-form-item label="地址" prop="address" class="anitem">
        <el-input type="text" v-model="registerForm.address" auto-complete="off" placeholder="不得为空"></el-input>
      </el-form-item>



      <el-form-item >
        <el-button type="primary"  v-on:click="register('registerForm')" class="threebutton" plain>注册</el-button>
      </el-form-item>
      <el-form-item >
        <router-link to="/Login">
          <el-button type="primary"  class="threebutton" plain>已有账号，去登录</el-button>
        </router-link>
      </el-form-item>
    </el-form>

    </div>

  </div>
</template>

<script>
export default {
  name: "Register",
  data(){
    var validateusername = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入用户名'));
      }
      else {
        callback();
      }
    };
    var validateemail = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入电子邮件'));
      }
      else {
        callback();
      }
    };
    var validatetel = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入电话'));
      }
      else {
        callback();
      }
    };
    var validateaddress = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入地址'));
      }
      else {
        callback();
      }
    };
    var validatepassword = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入密码'));
      } else {
        if ((value.search(/[a-z]/i) == -1)||(value.search(/[0-9]/) == -1)) {
          callback(new Error('密码需同时包含字母和数字'));
        }
        else {
          this.$refs.registerForm.validateField('checkpassword');
        }
        callback();
      }
    };
    var validatecheckpassword = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请再次输入密码'));
      } else if (value !== this.registerForm.password) {
        callback(new Error('两次输入密码不一致!'));
      } else {
        return callback();
      }
    };

    return{
      registerForm: {
        name: '',
        password: '',
        checkpassword: '',
        email: '',
        tel: '',
        address: '',
      },
      rules:{
        name: [
          {validator: validateusername, trigger: 'blur'}
        ],
        password: [
          {validator: validatepassword, trigger: 'blur'}
        ],
        checkpassword: [
          {validator: validatecheckpassword, trigger: 'blur' }
        ],
        email: [
          {validator: validateemail, trigger: 'blur' }
        ],
        tel: [
          {validator: validatetel, trigger: 'blur' }
        ],
        address: [
          {validator: validateaddress, trigger: 'blur' }
        ],
      }
    }
  },
  methods:{
    register (formName){
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.$axios.post('Register.php',this.$qs.stringify(
              {
                "name":this.registerForm.name,
                "password":this.registerForm.password,
                "email":this.registerForm.email,
                "tel":this.registerForm.tel,
                "address":this.registerForm.address
              }

          )).then(
              resp =>{
                if(resp.data[0]=="1"){
                  alert("注册成功");
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
                  alert("注册失败\n系统中已存在同⽤户名的⽤户，请选取新的⽤户名");
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
/*.register_container{*/
/*  margin-left: 0;*/
/*  margin-right: 0;*/
/*  padding: 0 0 0 0;*/
/*}*/

.anitem{
  width:30%;
  margin-left: auto;
  margin-right: auto;
}
.register_container{
  margin-top: 3%;
}

/*.threebutton{*/
/*  margin-left: auto;*/
/*  margin-right: auto;*/
/*}*/
</style>