import type { Ref } from "vue";

export const useAuth = () => {
  const userId = useState("userId", () => 1);

  const cookie = useCookie("access_token");
  // サンプルではcookieの存在有無だけ
  // TODO: validate
  const initialValue = cookie.value ? true : false;

  const loggedIn = useState("loggedIn", () => initialValue);
  const userName = useState("userName", () => "初期値");

  const handleLogin =
    (loggedIn: Ref<boolean>, userName: Ref<string>) =>
    async (email: string) => {
      const data = await $fetch("/api/login");
      if (email === "ryoya.takeuchi@icloud.com") {
        cookie.value = data.accessToken;
        loggedIn.value = true;
        userName.value = "りょうや";
      } else {
        loggedIn.value = false;
        userName.value = "なんか違う";
      }
    };

  const handleLogout =
    (loggedIn: Ref<boolean>, userName: Ref<string>) => () => {
      loggedIn.value = false;
      userName.value = "";
      cookie.value = null;
    };

  const getToken = () => {
    return cookie.value;
  };

  return {
    loggedIn,
    userId,
    userName,
    handleLogin: handleLogin(loggedIn, userName),
    handleLogout: handleLogout(loggedIn, userName),
    getToken,
  };
};
