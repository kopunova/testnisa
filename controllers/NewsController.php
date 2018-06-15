<?php

namespace app\controllers;

use Yii;
use app\models\News;
use app\models\NewsSearch;
use app\models\Log;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionList() {		
		$query = News::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

        return $this->render('list', [
                    'models' => $models,
                    'pages' => $pages,
        ]);
		       
    }
	
	private function Log($id) {
				
		$country_code = Yii::$app->geoip->ip(Yii::$app->request->userIP)->isoCode;
			
		// регистрируем click
		$log = new Log();
        $log->news_id = $id;
        $log->action = 'click';
        $log->country_code = $country_code;
		//$log->country_code = 'uk';
		$log->date = date('Y-m-d');

        $log->save();	
			
		// регистрируем unique_click
		if(!isset($_COOKIE['news'.$id])) {
			setcookie('news'.$id, 'news'.$id, time()+60*60*24*365*10);
			$log = new Log();
			$log->news_id = $id;
			$log->action = 'unique_click';
			$log->country_code = $country_code;
			//$log->country_code = 'uk';
			$log->date = date('Y-m-d');

			$log->save();				
		}		
		       
    }
	
	public function actionStat() {

		return $this->render('stat');
		       
    }
	
	public function actionReport() {
				
		$query = (new \yii\db\Query())->select([
                    'news_id',
					'country_code',
					'date',
                    "sum(IF(action = 'unique_click', 1, 0)) AS `unique_clicks`",
                    "sum(IF(action = 'click', 1, 0)) AS `clicks`"])
                ->from('log')              
                ->groupBy(['news_id', 'date', 'country_code'])
                ->orderBy('news_id', 'date', 'country_code');
		
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $posts = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
						
		return $this->render('report', [
                    'posts' => $posts,
                    'pages' => $pages,
        ]);
    }	

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		self::log($id);
		
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
