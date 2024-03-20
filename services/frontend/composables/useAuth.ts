export const useAuth = () => {
  const token = useCookie("XSRF-TOKEN");

  return useState("isAuth", () => !!token.value);
};
