# User
## User Interests
A user can have many or no interest
```mysql
select interest_id, i.keyword, i.category_id
from user_interests ui
inner join interests i on ui.interest_id = i.id
order by i.category_id
```

# Places
## Places Categories
places belongs to one category
those a place belongs to all interests in the category
```mysql
select category,sub_category, place_type from places;
```

## Places Sub Category
places belongs to many sub categories and can be null
sub categories are actually called place types in the app
```mysql
select category,sub_category, place_type from places;
```


## Places Types
places types are used as sub-categories
It still depends on category which makes it redundant
```mysql
select category_id, pt.name, ptt.name, ptt.locale
from place_types pt
         inner join rukutaykaw.place_type_translations ptt on pt.id = ptt.place_type_id
```


## Places Interests
places are linked to the category they belong. 
They aren't using the table below

```mysql
select * from place_interests
```

# Interests
## Interests Table
Interests belongs to one category
```mysql
select i.category_id, i.keyword
from interests i;
```