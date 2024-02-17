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

            <td v-else-if="typeof header.key === 'number'">
              {{ dateFormat(item.interviews[header.key].interview) }}
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
    name: "株式会社 坂本",
    favorite: 0,
    url: "http://www.nakamura.info/id-a-qui-ipsa-reiciendis-ipsam-quisquam.html",
    login: "Eye7Fmihsn",
    note: "Ab molestiae earum quod fugiat incidunt quia.",
    es: "2024-12-26",
    es_note: "Nihil numquam perspiciatis ut molestiae.",
    es_result: 2,
    test: "2024-09-12",
    test_type: 4,
    test_note: "Ipsum ea aut deleniti dolores tempore fugit.",
    test_result: 0,
    gd: "2024-07-29",
    gd_note:
      "Ex voluptatem labore repudiandae voluptatem omnis ut dignissimos.",
    gd_result: 0,
    result: 3,
    interviews: [
      {
        id: 3,
        company_id: 1,
        interview: "2024-04-09",
        note: "Est sunt modi praesentium possimus et.",
        result: 1,
      },
      {
        id: 1,
        company_id: 1,
        interview: "2024-07-01",
        note: "Ipsum voluptas accusamus nihil.",
        result: 1,
      },
      {
        id: 2,
        company_id: 1,
        interview: "2024-10-13",
        note: "Ipsa voluptatem et corrupti labore.",
        result: 2,
      },
    ],
  },
  {
    id: 2,
    name: "有限会社 西之園",
    favorite: 0,
    url: "http://hamada.net/fugiat-culpa-reiciendis-dolorum-commodi-id-quos-sed",
    login: "8pdMjfPE2i",
    note: "Qui ut consequatur nisi repellendus animi in.",
    es: "2024-03-22",
    es_note: "Occaecati optio eveniet fugit et velit.",
    es_result: 3,
    test: "2024-10-01",
    test_type: 4,
    test_note: "Qui in et voluptate voluptatibus quia.",
    test_result: 1,
    gd: "2024-07-13",
    gd_note: "Molestias eum sunt earum perspiciatis.",
    gd_result: 1,
    result: 0,
    interviews: [
      {
        id: 4,
        company_id: 2,
        interview: "2024-03-27",
        note: "Rerum ut illum et eaque doloribus non repellat.",
        result: 1,
      },
      {
        id: 5,
        company_id: 2,
        interview: "2024-07-02",
        note: "Natus aut adipisci modi eius.",
        result: 1,
      },
      {
        id: 6,
        company_id: 2,
        interview: "2024-10-17",
        note: "Corporis quo voluptatibus dignissimos.",
        result: 3,
      },
    ],
  },
  {
    id: 3,
    name: "有限会社 小泉",
    favorite: 0,
    url: "http://www.yamamoto.jp/atque-qui-soluta-aut-repellendus",
    login: "I1PAYdj2Xc",
    note: "Sunt ut quaerat sequi sunt rem omnis.",
    es: "2024-07-28",
    es_note: "Est unde saepe explicabo facilis.",
    es_result: 2,
    test: "2024-06-17",
    test_type: 5,
    test_note: "Animi dolores omnis corporis esse.",
    test_result: 4,
    gd: "2024-11-05",
    gd_note: "Culpa ut sequi similique eveniet rerum nam.",
    gd_result: 4,
    result: 2,
    interviews: [
      {
        id: 9,
        company_id: 3,
        interview: "2024-01-31",
        note: "Id qui voluptates voluptatem qui et sed dolorem.",
        result: 3,
      },
      {
        id: 8,
        company_id: 3,
        interview: "2024-07-13",
        note: "Qui natus quisquam laudantium occaecati.",
        result: 0,
      },
      {
        id: 7,
        company_id: 3,
        interview: "2024-10-05",
        note: "Minus et ab voluptatem sed reprehenderit.",
        result: 4,
      },
    ],
  },
  {
    id: 4,
    name: "株式会社 喜嶋",
    favorite: 0,
    url: "http://koizumi.com/libero-earum-corrupti-voluptate.html",
    login: "0VVMBttQwo",
    note: "Molestiae voluptatum harum voluptatibus voluptate autem.",
    es: "2024-02-04",
    es_note: "Distinctio in consequatur enim consequatur.",
    es_result: 2,
    test: "2024-10-11",
    test_type: 5,
    test_note: "Consequatur accusantium odit eum eaque dignissimos.",
    test_result: 1,
    gd: "2024-02-27",
    gd_note: "Ut sapiente vitae aut officiis blanditiis quod.",
    gd_result: 2,
    result: 3,
    interviews: [
      {
        id: 12,
        company_id: 4,
        interview: "2024-03-04",
        note: "Quas magnam aliquid architecto distinctio.",
        result: 3,
      },
      {
        id: 10,
        company_id: 4,
        interview: "2024-07-22",
        note: "Id iste voluptas distinctio voluptatum delectus.",
        result: 0,
      },
      {
        id: 11,
        company_id: 4,
        interview: "2024-12-23",
        note: "Molestiae molestiae officiis tenetur perferendis.",
        result: 2,
      },
    ],
  },
  {
    id: 5,
    name: "株式会社 山口",
    favorite: 0,
    url: "http://www.saito.biz/voluptatem-rem-commodi-qui-aut-dicta-enim-est",
    login: "ET2fqmcVEL",
    note: "Quasi officia odio veniam.",
    es: "2024-04-18",
    es_note: "Nihil ex nihil sit aut doloremque et.",
    es_result: 1,
    test: "2024-11-05",
    test_type: 2,
    test_note: "Earum omnis quas eligendi saepe.",
    test_result: 1,
    gd: "2024-08-14",
    gd_note: "Animi magnam autem nostrum molestiae nam rem dolor.",
    gd_result: 0,
    result: 0,
    interviews: [
      {
        id: 14,
        company_id: 5,
        interview: "2024-03-28",
        note: "Velit suscipit et eveniet dolore id.",
        result: 2,
      },
      {
        id: 13,
        company_id: 5,
        interview: "2024-04-21",
        note: "Facere quo accusantium vel ex odio sit deserunt.",
        result: 2,
      },
      {
        id: 15,
        company_id: 5,
        interview: "2024-12-05",
        note: "Rem nemo non nesciunt vero excepturi commodi consectetur architecto.",
        result: 3,
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
