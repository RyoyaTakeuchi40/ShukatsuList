<script setup lang="ts">
import { ref } from 'vue'

const headers = [
  '☆',
  'name',
  'result',
  'login',
  'es',
  'test',
  'gd',
  'interview_1',
  'interview_2',
  'interview_3',
  'interview_dates',
  'acitons'
]
const items = [
  {
    id: '1',
    name: 'ウルシステムズ',
    favorite: '1',
    es: null,
    check_es: '1',
    memo_es: '',
    test: null,
    test_type: '0',
    check_test: '2',
    interview_1: null,
    check_1: '3',
    memo_1: '',
    interview_2: null,
    check_2: '4',
    memo_2: '',
    interview_3: null,
    check_3: '0',
    memo_3: '',
    result: '1',
    url: 'https://ulsystems-recruit.snar.jp/login.aspx',
    login: 'UL00004855',
    interview_dates: null
  },
  {
    id: '18',
    name: 'Simplex',
    favorite: '1',
    es: null,
    check_es: '0',
    memo_es: '',
    test: null,
    test_type: '0',
    check_test: '0',
    interview_1: null,
    check_1: '0',
    memo_1: '',
    interview_2: null,
    check_2: '0',
    memo_2: '',
    interview_3: null,
    check_3: '0',
    memo_3: '',
    result: '1',
    url: 'https://mypage.3150.i-webs.jp/simplex2025/',
    login: 'S25002021',
    interview_dates: null
  },
  {
    id: '19',
    name: 'ビッグツリー',
    favorite: '0',
    es: null,
    check_es: '0',
    memo_es: null,
    test: null,
    test_type: '0',
    check_test: '0',
    interview_1: null,
    check_1: '0',
    memo_1: null,
    interview_2: null,
    check_2: '0',
    memo_2: null,
    interview_3: null,
    check_3: '0',
    memo_3: null,
    result: '1',
    url: 'https://bigtreetc.snar.jp/login.aspx',
    login: 'BR00029951',
    interview_dates: null
  },
  {
    id: '20',
    name: 'ベイカレ',
    favorite: '0',
    es: null,
    check_es: '0',
    memo_es: null,
    test: null,
    test_type: '0',
    check_test: '0',
    interview_1: null,
    check_1: '0',
    memo_1: null,
    interview_2: null,
    check_2: '0',
    memo_2: null,
    interview_3: null,
    check_3: '0',
    memo_3: null,
    result: '0',
    url: 'https://job.axol.jp/hy/s/baycurrent_25/mypage/top',
    login: 'y1w1076307',
    interview_dates: null
  },
  {
    id: '23',
    name: 'EY',
    favorite: '1',
    es: null,
    check_es: '0',
    memo_es: null,
    test: null,
    test_type: '0',
    check_test: '0',
    interview_1: null,
    check_1: '0',
    memo_1: null,
    interview_2: null,
    check_2: '0',
    memo_2: null,
    interview_3: null,
    check_3: '0',
    memo_3: null,
    result: '0',
    url: 'https://job.axol.jp/hy/s/ey_25/mypage/login',
    login: 't3c1032199',
    interview_dates: null
  },
  {
    id: '7',
    name: 'アーキテクティング塾',
    favorite: '1',
    es: '2023-06-09',
    check_es: '3',
    memo_es: '',
    test: null,
    test_type: '3',
    check_test: '0',
    interview_1: '2023-08-22',
    check_1: '0',
    memo_1: '22〜25',
    interview_2: '2023-08-29',
    check_2: '0',
    memo_2: '29〜1',
    interview_3: null,
    check_3: '0',
    memo_3: '',
    result: '2',
    url: 'https://www.accenture.com/jp-ja/careers/local/students-internship',
    login: '',
    interview_dates: null
  },
  {
    id: '11',
    name: '野村総研',
    favorite: '0',
    es: '2023-06-06',
    check_es: '3',
    memo_es: '',
    test: null,
    test_type: '0',
    check_test: '0',
    interview_1: '2023-09-04',
    check_1: '0',
    memo_1: '4~8',
    interview_2: '2023-06-28',
    check_2: '2',
    memo_2: '',
    interview_3: null,
    check_3: '0',
    memo_3: '',
    result: '2',
    url: 'https://working.nri.co.jp/mypage2025/',
    login: '25005435',
    interview_dates: null
  },
  {
    id: '17',
    name: '楽天証券',
    favorite: '0',
    es: '2023-07-23',
    check_es: '0',
    memo_es: '',
    test: null,
    test_type: '0',
    check_test: '0',
    interview_1: '2023-08-10',
    check_1: '0',
    memo_1: '',
    interview_2: null,
    check_2: '0',
    memo_2: '',
    interview_3: null,
    check_3: '0',
    memo_3: '',
    result: '3',
    url: 'https://rakuten-sec.snar.jp/login.aspx',
    login: 'RS00014376',
    interview_dates: null
  },
  {
    id: '8',
    name: 'PwC DC',
    favorite: '1',
    es: '2023-06-17',
    check_es: '2',
    memo_es: '',
    test: '2023-07-02',
    test_type: '6',
    check_test: '1',
    interview_1: null,
    check_1: '0',
    memo_1: '',
    interview_2: null,
    check_2: '0',
    memo_2: '',
    interview_3: null,
    check_3: '0',
    memo_3: '',
    result: '2',
    url: 'https://mypage.3150.i-webs.jp/pwc_newgrads25/',
    login: 'PWC004555',
    interview_dates: null
  },
  {
    id: '16',
    name: 'PwC ITSC',
    favorite: '1',
    es: '2023-09-01',
    check_es: '2',
    memo_es: '',
    test: '2023-06-10',
    test_type: '6',
    check_test: '1',
    interview_1: null,
    check_1: '0',
    memo_1: '',
    interview_2: null,
    check_2: '0',
    memo_2: '',
    interview_3: null,
    check_3: '0',
    memo_3: '',
    result: '2',
    url: 'https://mypage.3150.i-webs.jp/pwc_newgrads25/',
    login: 'PWC004555',
    interview_dates: null
  },
  {
    id: '21',
    name: 'タタコンサル',
    favorite: '1',
    es: '2023-07-23',
    check_es: '1',
    memo_es: '',
    test: '2023-07-23',
    test_type: '6',
    check_test: '0',
    interview_1: null,
    check_1: '0',
    memo_1: '',
    interview_2: null,
    check_2: '0',
    memo_2: '',
    interview_3: null,
    check_3: '0',
    memo_3: '',
    result: '1',
    url: 'https://mypage.3150.i-webs.jp/tcs2025/applicant/top/index/pra/bgijifgdbb-ihh',
    login: 'TCS002955',
    interview_dates: null
  },
  {
    id: '22',
    name: 'フェンリル',
    favorite: '0',
    es: '2023-07-20',
    check_es: '1',
    memo_es: '',
    test: '2023-07-23',
    test_type: '9',
    check_test: '1',
    interview_1: null,
    check_1: '0',
    memo_1: '',
    interview_2: null,
    check_2: '0',
    memo_2: '',
    interview_3: null,
    check_3: '0',
    memo_3: '',
    result: '4',
    url: '',
    login: '',
    interview_dates: null
  },
  {
    id: '12',
    name: '楽天',
    favorite: '0',
    es: '2023-05-29',
    check_es: '2',
    memo_es: '',
    test: '2023-05-29',
    test_type: '9',
    check_test: '2',
    interview_1: '2023-08-21',
    check_1: '0',
    memo_1: '21~25',
    interview_2: '2023-09-04',
    check_2: '0',
    memo_2: '4~8',
    interview_3: '2023-09-11',
    check_3: '0',
    memo_3: '11~15',
    result: '3',
    url: 'https://www.e2r.jp/ja/rakuten_recruit/?l-id=/graduates/engineer/login',
    login: '3144951',
    interview_dates: '2023-05-29'
  },
  {
    id: '2',
    name: 'エンジニア塾',
    favorite: '1',
    es: '2023-06-09',
    check_es: '3',
    memo_es: '',
    test: '2023-06-09',
    test_type: '3',
    check_test: '1',
    interview_1: '2023-09-12',
    check_1: '0',
    memo_1: '12~15',
    interview_2: '2023-09-19',
    check_2: '0',
    memo_2: '19~22',
    interview_3: '2023-10-10',
    check_3: '0',
    memo_3: '10~13',
    result: '3',
    url: 'https://job.axol.jp/hy/s/accenture_25/mypage/login',
    login: 'j3j1142006',
    interview_dates: '2023-06-09'
  },
  {
    id: '10',
    name: 'FUTURE project camp',
    favorite: '1',
    es: '2023-06-18',
    check_es: '1',
    memo_es: '',
    test: '2023-06-18',
    test_type: '10',
    check_test: '1',
    interview_1: '2023-08-23',
    check_1: '0',
    memo_1: '23〜25',
    interview_2: '2023-08-30',
    check_2: '0',
    memo_2: '30〜1',
    interview_3: '2023-09-06',
    check_3: '0',
    memo_3: '6〜8',
    result: '1',
    url: 'https://job.axol.jp/hy/s/future_25/mypage/login',
    login: 'r5b1026595',
    interview_dates: '2023-06-18'
  }
]

const select = ref('選考中')
// できれば
// const select = ref(['選考中'])

const clickRow = (id: number) => {
  console.log('Row:', id)
  // window.open(`/${id}`, '_blanck')
}
const clickFavorite = (id: number, favorite: number) => {
  console.log('Favorite:', id, favorite)
}
const clickLink = (url: string) => {
  console.log('URL:', url)
  // window.open(`${url}`, '_blanck')
}
const bgColor = (result: number) => {
  if (result == 1) {
    return 'bg-teal-lighten-5'
  } else if (result == 2) {
    return 'bg-blue-lighten-3'
  } else if (result == 3) {
    return 'bg-red-lighten-4'
  } else if (result == 4) {
    return 'bg-grey-darken-1'
  } else {
    return ''
  }
}

const displayContents = (result: number, favorite: number) => {
  if (select.value.includes('選考前')) {
    return result == 0
  }
  if (select.value.includes('選考中')) {
    return result == 1
  }
  if (select.value.includes('内定')) {
    return result == 2
  }
  if (select.value.includes('お祈り')) {
    return result == 3
  }
  if (select.value.includes('辞退')) {
    return result == 4
  }
  if (select.value.includes('☆')) {
    return favorite == 1
  }
  return true
}

const displayResult = (result: number) => {
  if (result == 1) {
    return '選考中'
  } else if (result == 2) {
    return '内定'
  } else if (result == 3) {
    return 'お祈り'
  } else if (result == 4) {
    return '辞退'
  } else {
    return ''
  }
}
</script>

<template>
  <v-table :hover="true" class="text-no-wrap">
    <template v-slot:top>
      <v-toolbar>
        <v-toolbar-title>タイトル</v-toolbar-title>
        <v-spacer />
        <v-select
          v-model="select"
          :items="['☆', '選考前', '選考中',  '内定', 'お祈り', '辞退', '全て']"
          density="comfortable"
          variant="underlined"
        />
      </v-toolbar>
    </template>

    <thead>
      <tr>
        <template v-for="header in headers" :key="header.key">
          <th v-if="header == 'name'" class="text-left">{{ header }}</th>
          <th v-else-if="header == 'test'" class="text-center" colspan="2">{{ header }}</th>
          <th v-else class="text-center">{{ header }}</th>
        </template>
      </tr>
    </thead>

    <tbody>
      <tr
        v-for="item in items"
        :key="item.id"
        @click="clickRow(item.id)"
        :class="bgColor(item.result)"
      >
        <template v-if="displayContents(item.result, item.favorite)">
          <td>
            <v-checkbox-btn
              :model-value="item.favorite == 1"
              @click="clickFavorite(item.id, item.favorite)"
            />
          </td>
          <td>
            {{ item.name }}
            <v-btn
              v-if="item.url"
              icon="mdi-open-in-new"
              size="small"
              variant="plain"
              @click="clickLink(item.url)"
            ></v-btn>
          </td>
          <td>{{ displayResult(item.result) }}{{ item.result }}</td>
          <td>{{ item.login }}</td>
          <td>{{ item.es }}</td>
          <td>{{ item.test }}</td>
          <td>{{ item.test_type }}</td>
          <td>{{ item.gd }}</td>
          <template v-for="i in 3" :key="i">
            <td>{{ item[`interview_${i}`] }}</td>
          </template>
          <td>{{ item.interview_dates }}</td>
          <td>
            <v-btn icon="mdi-pencil" size="small" variant="plain"></v-btn>
            <v-btn icon="mdi-delete" size="small" variant="plain"></v-btn>
          </td>
        </template>
      </tr>
    </tbody>
  </v-table>
</template>

<style scoped></style>
