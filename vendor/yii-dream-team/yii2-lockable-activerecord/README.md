# Pessimistic locking behavior for Yii2 ActiveRecord

This package allows you to use pessimistic locking (select for update) when you work with ActiveRecord models.

## Installation ##

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

    php composer.phar require --prefer-dist yii-dream-team/yii2-lockable-activerecord "*"

or add

    "yii-dream-team/yii2-lockable-activerecord": "*"

to the `require` section of your composer.json.

## Usage ##
Attach the behavior to your controller class.

    public function behaviors()
    {
        return [
            '\yiidreamteam\behaviors\LockableActiveRecord',
        ];
    }
    
Add @mixin phpdoc to you class definition.

    /**
     * Class Sample
     * @package common\models
     *
     * @mixin \yiidreamteam\behaviors\LockableActiveRecord
     */
    class Sample extends ActiveRecord { ... }
    
Use model locks in transaction.

    $dbTransaction = $model->getDb()->beginTransaction(\yii\db\Transaction::SERIALIZABLE);
    try {
        $model->lock();
        $model->doSomethingWhileLocked();
        $dbTransaction->commit();
    } catch(\Exception $e) {
        $dbTransaction->rollBack();
        throw $e;
    }
    
## Licence ##

MIT
    
## Links ##

* [Official site](http://yiidreamteam.com/yii2/lockable-activerecord)
* [Composer package](https://packagist.org/packages/yii-dream-team/yii2-lockable-activerecord)
* [Locking in MySQL InnoDB](https://dev.mysql.com/doc/refman/5.7/en/innodb-locking-reads.html)
* [Locking in PostgreSQL](https://www.postgresql.org/docs/9.4/static/explicit-locking.html)
