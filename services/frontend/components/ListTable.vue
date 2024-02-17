<template>
  <v-card>
    <v-data-table
      :headers="headers"
      :items="items"
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
            <td v-if="header.key === 'result'">
              <v-chip :color="chipColor(item.result)" size="small">
                {{ chipLabel(item.result) }}
              </v-chip>
            </td>

            <td v-else-if="header.key === 'name'">
              {{ item.name }}
              <v-btn
                v-if="item.url"
                icon="mdi-open-in-new"
                size="small"
                variant="plain"
                @click.stop="clickLink(item.url)"
              />
            </td>

            <td v-else-if="header.key === 'favorite'">
              <v-checkbox-btn
                :model-value="item.favorite === 1"
                @click.stop="clickFavorite(item.id, item.favorite)"
                true-icon="mdi-star"
                false-icon="mdi-star-outline"
              />
            </td>
            <td v-else-if="header.key === 'login'">
              {{ item[header.key] }}
            </td>

            <td
              v-else-if="header.key === 'test'"
              class="d-flex justify-between align-center"
              :class="tdBgColor(header.key, item)"
            >
              <div>{{ dateFormat(item.test) }}　</div>
              <div>{{ testTypeFormat(item.test_type) }}</div>
            </td>

            <td v-else-if="(typeof header.key === 'number')">
              {{ dateFormat(item.interviews[header.key].interview) }}
              {{ item.interviews[header.key].interview }}
            </td>

            <td v-else-if="header.key === 'delete'">
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
  { title: "1次面接", key: 0, align: "center" },
  { title: "2次面接", key: 1, align: "center" },
  { title: "3次面接", key: 2, align: "center" },
  { title: "", key: "delete", sortable: false },
];
const items = [
  {
    id: 1,
    name: "有限会社 山田",
    favorite: 0,
    url: "http://www.yamada.jp/hic-saepe-veniam-sunt-ut-perferendis-voluptas-et",
    login: "hffGriZD9f",
    note: "Autem non nulla ut alias nostrum velit.",
    es: "2014-11-20",
    es_note: "Qui vel minus qui illum et iure debitis.",
    es_result: 0,
    test: "2002-03-31",
    test_type: 4,
    test_note: "Quia sit consequatur sed quia sit.",
    test_result: 2,
    gd: "2017-07-24",
    gd_note: "Quaerat itaque praesentium quis excepturi est.",
    gd_result: 1,
    result: 2,
    interviews: [
      {
        id: 3,
        company_id: 1,
        interview: "1973-05-13",
        note: "Ex eos et vero qui.",
        result: 1,
      },
      {
        id: 2,
        company_id: 1,
        interview: "1994-05-26",
        note: "Deserunt molestiae perferendis ex voluptates quia tempora sed.",
        result: 2,
      },
      {
        id: 1,
        company_id: 1,
        interview: "2000-06-14",
        note: "Cum voluptatem voluptatum aut fugiat molestiae accusantium.",
        result: 4,
      },
    ],
  },
  {
    id: 2,
    name: "有限会社 中村",
    favorite: 0,
    url: "http://www.hamada.com/facere-cum-aut-adipisci-id",
    login: "fyzuvLYegC",
    note: "Voluptatem expedita quia ducimus illo veniam eos aut voluptatibus.",
    es: "2013-09-06",
    es_note: "Ea blanditiis optio provident id.",
    es_result: 2,
    test: "1983-03-28",
    test_type: 4,
    test_note: "Nihil et est error perspiciatis aperiam vitae.",
    test_result: 3,
    gd: "1998-12-14",
    gd_note: "Aut consequuntur fugit atque aut doloribus perferendis.",
    gd_result: 1,
    result: 3,
    interviews: [
      {
        id: 6,
        company_id: 2,
        interview: "1986-11-10",
        note: "In non sequi excepturi aspernatur dolore eligendi.",
        result: 3,
      },
      {
        id: 5,
        company_id: 2,
        interview: "1994-08-15",
        note: "Dignissimos non autem quae et sit.",
        result: 4,
      },
      {
        id: 4,
        company_id: 2,
        interview: "1998-12-01",
        note: "Quo molestiae iure delectus velit ut.",
        result: 0,
      },
    ],
  },
  {
    id: 3,
    name: "株式会社 山本",
    favorite: 0,
    url: "http://www.kanou.com/odit-adipisci-perspiciatis-deserunt",
    login: "69UMbxIeXm",
    note: "Voluptate quam vitae dolore perspiciatis asperiores id facere excepturi.",
    es: "2018-03-07",
    es_note: "Ut non voluptas consequatur molestiae ipsum officia temporibus.",
    es_result: 0,
    test: "1990-01-24",
    test_type: 2,
    test_note: "Reiciendis facilis error ad.",
    test_result: 4,
    gd: "1999-02-15",
    gd_note: "Id officia dolorem ut aut ipsam rerum.",
    gd_result: 3,
    result: 4,
    interviews: [
      {
        id: 9,
        company_id: 3,
        interview: "1990-05-01",
        note: "Nobis error quaerat magnam aut.",
        result: 3,
      },
      {
        id: 8,
        company_id: 3,
        interview: "2013-12-01",
        note: "Voluptatem eum tempore earum dolorum quibusdam fugiat atque.",
        result: 0,
      },
      {
        id: 7,
        company_id: 3,
        interview: "2015-06-19",
        note: "Deleniti id veniam eum et aperiam omnis minima.",
        result: 4,
      },
    ],
  },
  {
    id: 4,
    name: "有限会社 渚",
    favorite: 0,
    url: "http://www.kiriyama.jp/",
    login: "k7IwKsuSQK",
    note: "Excepturi recusandae tempore saepe omnis debitis officia minima quisquam.",
    es: "1974-11-18",
    es_note: "Sit autem commodi et id doloremque.",
    es_result: 0,
    test: "2014-03-09",
    test_type: 2,
    test_note: "Quo fugit asperiores doloribus dolores quidem ducimus quis.",
    test_result: 1,
    gd: "2021-05-12",
    gd_note: "Eum dolore sint vero rerum.",
    gd_result: 3,
    result: 4,
    interviews: [
      {
        id: 10,
        company_id: 4,
        interview: "1984-10-01",
        note: "Magnam assumenda voluptatem est optio velit.",
        result: 3,
      },
      {
        id: 12,
        company_id: 4,
        interview: "2000-03-24",
        note: "Voluptates nesciunt repellat aut et repellendus corporis.",
        result: 1,
      },
      {
        id: 11,
        company_id: 4,
        interview: "2003-05-15",
        note: "Laudantium adipisci ipsa est ut reprehenderit.",
        result: 3,
      },
    ],
  },
  {
    id: 5,
    name: "株式会社 田中",
    favorite: 0,
    url: "https://www.ishida.jp/quis-laborum-dolores-facilis-ea-dolorum-consequuntur-ducimus-sint",
    login: "XY5vMziBQR",
    note: "Repudiandae id quisquam rem consequatur.",
    es: "2024-01-30",
    es_note: "Praesentium voluptatum occaecati reprehenderit delectus.",
    es_result: 1,
    test: "1982-09-21",
    test_type: 4,
    test_note: "Deserunt et omnis minima tempore vero rerum.",
    test_result: 3,
    gd: "1984-12-15",
    gd_note: "Libero dolores qui enim consectetur id expedita iure.",
    gd_result: 2,
    result: 2,
    interviews: [
      {
        id: 14,
        company_id: 5,
        interview: "1976-09-30",
        note: "Reprehenderit ipsum et ipsa.",
        result: 3,
      },
      {
        id: 13,
        company_id: 5,
        interview: "1980-07-13",
        note: "Distinctio consectetur ut expedita sed veniam.",
        result: 1,
      },
      {
        id: 15,
        company_id: 5,
        interview: "2001-11-29",
        note: "Qui repudiandae est earum eos ullam recusandae neque.",
        result: 4,
      },
    ],
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
    return result === 0;
  }
  if (select.value.includes("選考中")) {
    return result === 1;
  }
  if (select.value.includes("内定")) {
    return result === 2;
  }
  if (select.value.includes("お祈り")) {
    return result === 3;
  }
  if (select.value.includes("辞退")) {
    return result === 4;
  }
  if (select.value.includes("お気に入り")) {
    return favorite === 1;
  }
  return true;
};
const chipLabel = (result: number) => {
  if (result === 1) {
    return "選考中";
  } else if (result === 2) {
    return "内　定";
  } else if (result === 3) {
    return "お祈り";
  } else if (result === 4) {
    return "辞　退";
  } else {
    return "選考前";
  }
};
const chipColor = (result: number) => {
  if (result === 1) {
    return "primary";
  } else if (result === 2) {
    return "success";
  } else if (result === 3) {
    return "error";
  } else if (result === 4) {
    return "";
  } else {
    return "secondary";
  }
};
const trBgColor = (result: number) => {
  if (result === 1) {
    return "bg-green-accent-1";
  } else if (result === 2) {
    return "bg-blue-accent-1";
  } else if (result === 3) {
    return "bg-red-accent-1";
  } else if (result === 4) {
    return "bg-grey-darken-1";
  } else {
    return "";
  }
};
const tdBgColor_ = (result: number) => {
  if (result === 1) {
    return "bg-grey-lighten-4";
  } else if (result === 2) {
    return "bg-grey-lighten-2";
  } else if (result === 3) {
    return "bg-grey-darken-2";
  } else if (result === 4) {
    return "bg-grey";
  } else {
    return "";
  }
};
const tdBgColor = (key: string, item: object) => {
  if (item.result === 1) {
    if (key === "es") {
      return tdBgColor_(item.check_es);
    } else if (key === "test") {
      return tdBgColor_(item.check_test);
    } else if (key === "gd") {
      return tdBgColor_(item.check_gd);
    } else if (key === "interview_1") {
      return tdBgColor_(item.check_1);
    } else if (key === "interview_2") {
      return tdBgColor_(item.check_2);
    } else if (key === "interview_3") {
      return tdBgColor_(item.check_3);
    }
  }
};
const testTypeFormat = (testType: number) => {
  if (testType === 1) {
    return "SPI";
  } else if (testType === 2) {
    return "玉手箱";
  } else if (testType === 3) {
    return "GAB";
  } else if (testType === 4) {
    return "CAB";
  } else if (testType === 5) {
    return "TG-WEB";
  } else if (testType === 6) {
    return "ENG";
  } else if (testType === 7) {
    return "CUBIC";
  } else if (testType === 8) {
    return "GPS";
  } else if (testType === 9) {
    return "技術テスト";
  } else if (testType === 10) {
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
