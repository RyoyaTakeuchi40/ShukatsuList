import type { UseFetchOptions } from "nuxt/dist/app/composables";

export const useApiFetch = (
  path: string,
  options: UseFetchOptions<any> = {}
) => {
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

  return useFetch("http://localhost:9000" + path, {
    credentials: "include",
    watch: false,
    ...options,
    headers: {
      ...headers,
      ...options?.headers,
    },
  });
};
