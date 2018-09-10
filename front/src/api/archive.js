import request from "@/utils/request";

export function getArchives() {
  return request({
    url: "archives",
    method: "get"
  });
}
