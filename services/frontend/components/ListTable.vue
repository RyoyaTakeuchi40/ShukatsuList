<template>
  <v-card>
    <v-data-table
      :headers="headers"
      :items="items.filter((item) => filterItems(item.result, item.favorite))"
      :hover="true"
      :hide-no-data="true"
      @click:row="clickRow"
      item-value="id"
      class="text-no-wrap"
    >
      <template v-slot:top>
        <v-toolbar>
          <v-toolbar-title>選考</v-toolbar-title>
          <v-spacer />
          <v-select
            v-model="select"
            :items="[
              'お気に入り',
              '選考前',
              '選考中',
              '内定',
              'お祈り',
              '辞退',
              '全て',
            ]"
            variant="underlined"
          />
        </v-toolbar>
      </template>

      <template v-slot:item="{ item }">
        <tr>
          <template v-for="header in headers">
            <td v-if="header.key == 'result'">
              <v-chip :color="chipColor(item.result)" size="small">
                {{ chipLabel(item.result) }}
              </v-chip>
            </td>

            <td v-else-if="header.key == 'name'">
              {{ item.name }}
              <!-- clickRowを呼ばないために.preventをつける -->
              <v-btn
                v-if="item.url"
                icon="mdi-open-in-new"
                size="small"
                variant="plain"
                @click.stop="clickLink(item.url)"
              />
            </td>

            <td v-else-if="header.key == 'favorite'">
              <!-- clickRowを呼ばないために.preventをつける -->
              <v-checkbox-btn
                :model-value="item.favorite == 1"
                @click.stop="clickFavorite(item.id, item.favorite)"
                true-icon="mdi-star"
                false-icon="mdi-star-outline"
              />
            </td>
            <td v-else-if="header.key == 'login'">
              {{ item[header.key] }}
            </td>

            <td
              v-else-if="header.key == 'test'"
              class="d-flex justify-between align-center"
              :class="tdBgColor(header.key, item)"
            >
              <div>{{ dateFormat(item.test) }}　</div>
              <div>{{ testTypeFormat(item.test_type) }}</div>
            </td>

            <td v-else-if="header.key == 'delete'">
              <v-dialog transition="dialog-bottom-transition" width="auto">
                <template v-slot:activator="{ props }">
                  <v-btn
                    v-bind="props"
                    icon="mdi-delete"
                    size="small"
                    variant="plain"
                  />
                </template>
                <template v-slot:default="{ isActive }">
                  <v-card>
                    <v-card-text>
                      「{{ item.name }}」の情報を本当に削除しますか？
                    </v-card-text>
                    <v-card-actions class="d-flex justify-end">
                      <v-btn
                        text="いいえ"
                        color="warning"
                        @click="isActive.value = false"
                      />
                      <v-btn
                        text="はい"
                        color="primary"
                        @click.stop="clickDelete(item.id)"
                        @click="isActive.value = false"
                      />
                    </v-card-actions>
                  </v-card>
                </template>
              </v-dialog>
            </td>

            <td v-else :class="tdBgColor(header.key, item)">
              {{ dateFormat(item[header.key]) }}
            </td>
          </template>
        </tr>
      </template>
    </v-data-table>
  </v-card>
</template>
<script setup lang="ts">
const headers = [
  { title: "", key: "result", sortable: false },
  { title: "", key: "name", sortable: false },
  { title: "", key: "favorite", align: "center" },
  {
    title: "ログインID",
    key: "login",
    class: "bg-blue-lighten-3",
    align: "center",
    sortable: false,
  },
  { title: "ES", key: "es", align: "center" },
  { title: "テスト", key: "test", align: "center" },
  { title: "GD", key: "gd", align: "center" },
  {
    title: "一次面接",
    key: "interview_1",
    align: "center",
  },
  {
    title: "二次面接",
    key: "interview_2",
    align: "center",
  },
  {
    title: "三次面接",
    key: "interview_3",
    align: "center",
  },
  {
    title: "interview_dates",
    key: "interview_dates",
    align: "center",
  },
  { title: "", key: "delete", sortable: false },
];
const items = [
  {
    id: "1",
    name: "ウルシステムズ",
    favorite: "1",
    es: null,
    check_es: "1",
    memo_es: "",
    test: null,
    test_type: "0",
    check_test: "2",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: null,
    check_1: "3",
    memo_1: "",
    interview_2: null,
    check_2: "4",
    memo_2: "",
    interview_3: null,
    check_3: "0",
    memo_3: "",
    result: "1",
    url: "https://ulsystems-recruit.snar.jp/login.aspx",
    login: "UL00004855",
    interview_dates: null,
  },
  {
    id: "18",
    name: "Simplex",
    favorite: "1",
    es: null,
    check_es: "0",
    memo_es: "",
    test: null,
    test_type: "0",
    check_test: "0",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: null,
    check_1: "0",
    memo_1: "",
    interview_2: null,
    check_2: "0",
    memo_2: "",
    interview_3: null,
    check_3: "0",
    memo_3: "",
    result: "1",
    url: "https://mypage.3150.i-webs.jp/simplex2025/",
    login: "S25002021",
    interview_dates: null,
  },
  {
    id: "19",
    name: "ビッグツリー",
    favorite: "0",
    es: null,
    check_es: "0",
    memo_es: null,
    test: null,
    test_type: "0",
    check_test: "0",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: null,
    check_1: "0",
    memo_1: null,
    interview_2: null,
    check_2: "0",
    memo_2: null,
    interview_3: null,
    check_3: "0",
    memo_3: null,
    result: "1",
    url: "https://bigtreetc.snar.jp/login.aspx",
    login: "BR00029951",
    interview_dates: null,
  },
  {
    id: "20",
    name: "ベイカレ",
    favorite: "0",
    es: null,
    check_es: "0",
    memo_es: null,
    test: null,
    test_type: "0",
    check_test: "0",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: null,
    check_1: "0",
    memo_1: null,
    interview_2: null,
    check_2: "0",
    memo_2: null,
    interview_3: null,
    check_3: "0",
    memo_3: null,
    result: "0",
    url: "https://job.axol.jp/hy/s/baycurrent_25/mypage/top",
    login: "y1w1076307",
    interview_dates: null,
  },
  {
    id: "23",
    name: "EY",
    favorite: "1",
    es: null,
    check_es: "0",
    memo_es: null,
    test: null,
    test_type: "0",
    check_test: "0",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: null,
    check_1: "0",
    memo_1: null,
    interview_2: null,
    check_2: "0",
    memo_2: null,
    interview_3: null,
    check_3: "0",
    memo_3: null,
    result: "0",
    url: "https://job.axol.jp/hy/s/ey_25/mypage/login",
    login: "t3c1032199",
    interview_dates: null,
  },
  {
    id: "7",
    name: "アーキテクティング塾",
    favorite: "1",
    es: "2023-06-09",
    check_es: "3",
    memo_es: "",
    test: null,
    test_type: "3",
    check_test: "0",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: "2023-08-22",
    check_1: "0",
    memo_1: "22〜25",
    interview_2: "2023-08-29",
    check_2: "0",
    memo_2: "29〜1",
    interview_3: null,
    check_3: "0",
    memo_3: "",
    result: "2",
    url: "https://www.accenture.com/jp-ja/careers/local/students-internship",
    login: "",
    interview_dates: null,
  },
  {
    id: "11",
    name: "野村総研",
    favorite: "0",
    es: "2023-06-06",
    check_es: "3",
    memo_es: "",
    test: null,
    test_type: "0",
    check_test: "0",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: "2023-09-04",
    check_1: "0",
    memo_1: "4~8",
    interview_2: "2023-06-28",
    check_2: "2",
    memo_2: "",
    interview_3: null,
    check_3: "0",
    memo_3: "",
    result: "2",
    url: "https://working.nri.co.jp/mypage2025/",
    login: "25005435",
    interview_dates: null,
  },
  {
    id: "17",
    name: "楽天証券",
    favorite: "0",
    es: "2023-07-23",
    check_es: "0",
    memo_es: "",
    test: null,
    test_type: "0",
    check_test: "0",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: "2023-08-10",
    check_1: "0",
    memo_1: "",
    interview_2: null,
    check_2: "0",
    memo_2: "",
    interview_3: null,
    check_3: "0",
    memo_3: "",
    result: "3",
    url: "https://rakuten-sec.snar.jp/login.aspx",
    login: "RS00014376",
    interview_dates: null,
  },
  {
    id: "8",
    name: "PwC DC",
    favorite: "1",
    es: "2023-06-17",
    check_es: "2",
    memo_es: "",
    test: "2023-07-02",
    test_type: "6",
    check_test: "1",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: null,
    check_1: "0",
    memo_1: "",
    interview_2: null,
    check_2: "0",
    memo_2: "",
    interview_3: null,
    check_3: "0",
    memo_3: "",
    result: "2",
    url: "https://mypage.3150.i-webs.jp/pwc_newgrads25/",
    login: "PWC004555",
    interview_dates: null,
  },
  {
    id: "16",
    name: "PwC ITSC",
    favorite: "1",
    es: "2023-09-01",
    check_es: "2",
    memo_es: "",
    test: "2023-06-10",
    test_type: "6",
    check_test: "1",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: null,
    check_1: "0",
    memo_1: "",
    interview_2: null,
    check_2: "0",
    memo_2: "",
    interview_3: null,
    check_3: "0",
    memo_3: "",
    result: "2",
    url: "https://mypage.3150.i-webs.jp/pwc_newgrads25/",
    login: "PWC004555",
    interview_dates: null,
  },
  {
    id: "21",
    name: "タタコンサル",
    favorite: "1",
    es: "2023-07-23",
    check_es: "1",
    memo_es: "",
    test: "2023-07-23",
    test_type: "6",
    check_test: "0",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: null,
    check_1: "0",
    memo_1: "",
    interview_2: null,
    check_2: "0",
    memo_2: "",
    interview_3: null,
    check_3: "0",
    memo_3: "",
    result: "1",
    url: "https://mypage.3150.i-webs.jp/tcs2025/applicant/top/index/pra/bgijifgdbb-ihh",
    login: "TCS002955",
    interview_dates: null,
  },
  {
    id: "22",
    name: "フェンリル",
    favorite: "0",
    es: "2023-07-20",
    check_es: "1",
    memo_es: "",
    test: "2023-07-23",
    test_type: "9",
    check_test: "1",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: null,
    check_1: "0",
    memo_1: "",
    interview_2: null,
    check_2: "0",
    memo_2: "",
    interview_3: null,
    check_3: "0",
    memo_3: "",
    result: "4",
    url: "",
    login: "",
    interview_dates: null,
  },
  {
    id: "12",
    name: "楽天",
    favorite: "0",
    es: "2023-05-29",
    check_es: "2",
    memo_es: "",
    test: "2023-05-29",
    test_type: "9",
    check_test: "2",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: "2023-08-21",
    check_1: "0",
    memo_1: "21~25",
    interview_2: "2023-09-04",
    check_2: "0",
    memo_2: "4~8",
    interview_3: "2023-09-11",
    check_3: "0",
    memo_3: "11~15",
    result: "3",
    url: "https://www.e2r.jp/ja/rakuten_recruit/?l-id=/graduates/engineer/login",
    login: "3144951",
    interview_dates: "2023-05-29",
  },
  {
    id: "2",
    name: "エンジニア塾",
    favorite: "1",
    es: "2023-06-09",
    check_es: "3",
    memo_es: "",
    test: "2023-06-09",
    test_type: "3",
    check_test: "1",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: "2023-09-12",
    check_1: "0",
    memo_1: "12~15",
    interview_2: "2023-09-19",
    check_2: "0",
    memo_2: "19~22",
    interview_3: "2023-10-10",
    check_3: "0",
    memo_3: "10~13",
    result: "3",
    url: "https://job.axol.jp/hy/s/accenture_25/mypage/login",
    login: "j3j1142006",
    interview_dates: "2023-06-09",
  },
  {
    id: "10",
    name: "FUTURE project camp",
    favorite: "1",
    es: "2023-06-18",
    check_es: "1",
    memo_es: "",
    test: "2023-06-18",
    test_type: "10",
    check_test: "1",
    gd: null,
    check_gd: "1",
    memo_gd: "",
    interview_1: "2023-08-23",
    check_1: "0",
    memo_1: "23〜25",
    interview_2: "2023-08-30",
    check_2: "0",
    memo_2: "30〜1",
    interview_3: "2023-09-06",
    check_3: "0",
    memo_3: "6〜8",
    result: "1",
    url: "https://job.axol.jp/hy/s/future_25/mypage/login",
    login: "r5b1026595",
    interview_dates: "2023-06-18",
  },
];

const select = ref("選考中");

const clickRow = (_: any, item: { item: { id: any } }) => {
  console.log("id:", item.item.id);
  // window.open(`/${id}`, '_blanck')
};
const clickFavorite = (id: number, favorite: number) => {
  console.log("Favorite:", id, favorite);
};
const clickLink = (url: string) => {
  console.log("URL:", url);
  window.open(`${url}`, "_blanck");
};
const clickDelete = (id: string) => {
  console.log("delete:", id);
};

const filterItems = (result: number, favorite: number) => {
  if (select.value.includes("選考前")) {
    return result == 0;
  }
  if (select.value.includes("選考中")) {
    return result == 1;
  }
  if (select.value.includes("内定")) {
    return result == 2;
  }
  if (select.value.includes("お祈り")) {
    return result == 3;
  }
  if (select.value.includes("辞退")) {
    return result == 4;
  }
  if (select.value.includes("お気に入り")) {
    return favorite == 1;
  }
  return true;
};
const chipLabel = (result: number) => {
  if (result == 1) {
    return "選考中";
  } else if (result == 2) {
    return "内　定";
  } else if (result == 3) {
    return "お祈り";
  } else if (result == 4) {
    return "辞　退";
  } else {
    return "選考前";
  }
};
const chipColor = (result: number) => {
  if (result == 1) {
    return "primary";
  } else if (result == 2) {
    return "success";
  } else if (result == 3) {
    return "error";
  } else if (result == 4) {
    return "";
  } else {
    return "secondary";
  }
};
const trBgColor = (result: number) => {
  if (result == 1) {
    return "bg-green-accent-1";
  } else if (result == 2) {
    return "bg-blue-accent-1";
  } else if (result == 3) {
    return "bg-red-accent-1";
  } else if (result == 4) {
    return "bg-grey-darken-1";
  } else {
    return "";
  }
};
const tdBgColor_ = (result: number) => {
  if (result == 1) {
    return "bg-grey-lighten-4";
  } else if (result == 2) {
    return "bg-grey-lighten-2";
  } else if (result == 3) {
    return "bg-grey-darken-2";
  } else if (result == 4) {
    return "bg-grey";
  } else {
    return "";
  }
};
const tdBgColor = (key: string, item: object) => {
  if (item.result == 1) {
    if (key == "es") {
      return tdBgColor_(item.check_es);
    } else if (key == "test") {
      return tdBgColor_(item.check_test);
    } else if (key == "gd") {
      return tdBgColor_(item.check_gd);
    } else if (key == "interview_1") {
      return tdBgColor_(item.check_1);
    } else if (key == "interview_2") {
      return tdBgColor_(item.check_2);
    } else if (key == "interview_3") {
      return tdBgColor_(item.check_3);
    }
  }
};
const testTypeFormat = (testType: number) => {
  if (testType == 1) {
    return "SPI";
  } else if (testType == 2) {
    return "玉手箱";
  } else if (testType == 3) {
    return "GAB";
  } else if (testType == 4) {
    return "CAB";
  } else if (testType == 5) {
    return "TG-WEB";
  } else if (testType == 6) {
    return "ENG";
  } else if (testType == 7) {
    return "CUBIC";
  } else if (testType == 8) {
    return "GPS";
  } else if (testType == 9) {
    return "技術テスト";
  } else if (testType == 10) {
    return "その他";
  } else {
    return " ";
  }
};
const dateFormat = (date: string) => {
  if (date) {
    const tmpDate = new Date(date);
    return tmpDate.toLocaleDateString("ja-JP", {
      month: "short",
      day: "numeric",
    });
  }
};
</script>

<style scoped></style>
