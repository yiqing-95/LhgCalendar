一个国产的日期类

### 用法
~~~
    <?php echo CHtml::textField('content','',array()); ?>

    <?php $this->widget('my.widgets.lhgcalendar.LhgCalendar',  array(
            'inputId'=>'content'
        )
    ); ?>
~~~