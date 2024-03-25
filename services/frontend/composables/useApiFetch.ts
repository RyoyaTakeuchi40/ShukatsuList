import type { UseFetchOptions } from "nuxt/dist/app/composables";

export const useApiFetch = (
  path: string,
  options: UseFetchOptions<any> = {}
) => {
  const runtimeConfig = useRuntimeConfig();

  let headers: any = {};
  const token = useCookie("XSRF-TOKEN");

  if (token.value) {
    headers["X-XSRF-TOKEN"] = token.value as string;
  }

  if (process.server) {
    headers = {
      ...headers,
      ...useRequestHeaders(["referer", "cookie"]),
    };
  }

  return useFetch(runtimeConfig.public.apiUrl + path, {
    credentials: "include",
    watch: false,
    ...options,
    headers: {
      ...headers,
      ...options?.headers,
    },
  });
};
