import request from "@/utils/request";

export function showAbout() {
  return request({
    url: "/abouts",
    method: "get"
  });
}
