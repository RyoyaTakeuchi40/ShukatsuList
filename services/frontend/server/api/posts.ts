import { getRequestHeader } from "h3";

export default defineEventHandler((event) => {
  const token = getRequestHeader(event, "Authorization");

  console.log(`token: ${token}`);

  // サンプルとしてtokenの有無だけチェック
  if (!token) {
    throw createError({
      statusCode: 401,
      statusMessage: "Not authorized",
    });
  }

  // TODO: validate(token)

  return {
    posts: [
      { title: "title1", content: "test content", author: "tarou" },
      { title: "title2", content: "test content2", author: "tarou" },
      { title: "title3", content: "test content3", author: "tarou" },
    ],
  };
});
