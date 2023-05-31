<template>
    <div class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
  
        <router-view :key="$route.fullPath"></router-view>
  
      </div>
    </div>
  </template>
  
  <script>
  export default {
    
  }
  </script>