<script>  
   function DisEn(X){  
      document.A.T1.disabled=X;
      document.A.T2.disabled=X;
   }  
</script>
</head>

<body>
   <form name="A" >
      <span class="toggle-bg">
         <input type="radio" name="toggle" value="off" onClick="DisEn(false)">
         <input type="radio" name="toggle" value="on" onClick="DisEn(true)">
         <span class="switch"></span>
      </span>
      <input type="text" name="T1" value="A" disabled>  
      <input type="text" name="T2" value="B" disabled>  
   </form>
</body>
</html>