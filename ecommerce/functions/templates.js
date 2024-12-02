function errorLogin() {
    // Chama o Swal.fire e retorna a Promise
    return Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Email ou senha incorretos!",
      confirmButtonText: "OK",
      showClass: {
        popup: `
                  animate__animated
                  animate__jackInTheBox
              `,
      },
      confirmButtonColor: "#090D59",
      background: "#FFF",
      backdrop: `
              rgb(9,13,99)
              url(../assets/images/icons/Marca-home.svg)
              center top
              no-repeat
          `,
      footer: "<a href='../views/recuperarSenha.html'>Esqueceu sua senha?</a>",
      color: "#000",
    }).then((result) => {
      if (result.isConfirmed) {
        // Aqui você pode adicionar a lógica após o alerta ser confirmado
        window.history.back();
      }
    });
  }
  function errorGeral(texto) {
    return Swal.fire({
      toast: true,
      icon: "error",
      title: "Erro!",
      text: texto,
      confirmButtonText: "OK",
    }).then((result) => {
      if (result.isConfirmed) {
        window.history.back();
      }
    });
  }
  function sucessoGeral(texto) {
    return Swal.fire({
      toast: true,
      timer: 2000,
      icon: "success",
      title: "Sucesso!",
      text: texto,
    }).then((result) => {
      if (result.isConfirmed) {
        window.history.back();
      }
    });
  }
  // Configuração comum para toast
  function createToast(icon, title) {
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      },
    });
    return Toast.fire({
      icon,
      title,
    });
  }
  function sucessLogin() {
    createToast("success", "Login efetuado com sucesso!");
  }

  function sucessAlterarDados() {
    createToast("success", "Dados alterados com sucesso!");
  }

  export { errorLogin, errorGeral, sucessLogin, sucessoGeral, sucessAlterarDados 
};