export const useAuth = () => {
  const token = useCookie("token");

  return useState("isAuth", () => !!token.value);
};
