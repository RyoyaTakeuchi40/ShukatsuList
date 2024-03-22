type User = {
  id: number;
  name: string;
  email: string;
};

export const useAuth = () => {
  const user = useState<User | null>("user", () => null);

  const isLoggedIn = computed(() => !!user.value);

  const fetchUser = async () => {
    const { data } = await useApiFetch("/api/user");
    user.value = data.value as User;
  };

  const logout = async () => {
    await useApiFetch("/logout", {
      method: "POST",
    })
      .then((res) => {
        const data = res.data.value;
        const error = res.error.value;
        if (error) {
          console.log("error", error.data);
        } else {
          user.value = null;
          navigateTo("/login");
        }
      })
      .catch(({ error }) => {
        console.log("exceptional...", error.value);
      });
  };
  return { user, isLoggedIn, fetchUser, logout };
};
