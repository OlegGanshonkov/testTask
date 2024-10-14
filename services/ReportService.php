<?php

namespace app\services;

class ReportService
{

    public function top10(array $params = [])
    {
        $year = $params['year'] ?? 2000;
        $sql = (new \yii\db\Query())
            ->select(['concat(author.last, " ", author.first, " ", author.middle) as full_name', 'count(author.id) as count'])
            ->from('author')
            ->join('join', 'book_authors', 'author.id = book_authors.author_id')
            ->join('join', 'book', 'book.id = book_authors.book_id')
            ->where(['book.year' => $year])
            ->groupBy('full_name')
            ->orderBy(['count' => SORT_DESC]);

        $totalCount = $sql->count();
//        $sql->limit(10);

        return [
            'sql' => $sql->createCommand()->getRawSql(),
            'totalCount' => $totalCount,
        ];
    }

}