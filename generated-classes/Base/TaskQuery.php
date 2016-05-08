<?php

namespace Base;

use \Task as ChildTask;
use \TaskQuery as ChildTaskQuery;
use \Exception;
use \PDO;
use Map\TaskTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'task' table.
 *
 *
 *
 * @method     ChildTaskQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTaskQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildTaskQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildTaskQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildTaskQuery orderByPoints($order = Criteria::ASC) Order by the points column
 * @method     ChildTaskQuery orderByFlag($order = Criteria::ASC) Order by the flag column
 * @method     ChildTaskQuery orderByLogoLink($order = Criteria::ASC) Order by the logo_link column
 *
 * @method     ChildTaskQuery groupById() Group by the id column
 * @method     ChildTaskQuery groupByCategoryId() Group by the category_id column
 * @method     ChildTaskQuery groupByTitle() Group by the title column
 * @method     ChildTaskQuery groupByDescription() Group by the description column
 * @method     ChildTaskQuery groupByPoints() Group by the points column
 * @method     ChildTaskQuery groupByFlag() Group by the flag column
 * @method     ChildTaskQuery groupByLogoLink() Group by the logo_link column
 *
 * @method     ChildTaskQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTaskQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTaskQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTaskQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTaskQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTaskQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTaskQuery leftJoinCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Category relation
 * @method     ChildTaskQuery rightJoinCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Category relation
 * @method     ChildTaskQuery innerJoinCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the Category relation
 *
 * @method     ChildTaskQuery joinWithCategory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Category relation
 *
 * @method     ChildTaskQuery leftJoinWithCategory() Adds a LEFT JOIN clause and with to the query using the Category relation
 * @method     ChildTaskQuery rightJoinWithCategory() Adds a RIGHT JOIN clause and with to the query using the Category relation
 * @method     ChildTaskQuery innerJoinWithCategory() Adds a INNER JOIN clause and with to the query using the Category relation
 *
 * @method     ChildTaskQuery leftJoinstatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the statistic relation
 * @method     ChildTaskQuery rightJoinstatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the statistic relation
 * @method     ChildTaskQuery innerJoinstatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the statistic relation
 *
 * @method     ChildTaskQuery joinWithstatistic($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the statistic relation
 *
 * @method     ChildTaskQuery leftJoinWithstatistic() Adds a LEFT JOIN clause and with to the query using the statistic relation
 * @method     ChildTaskQuery rightJoinWithstatistic() Adds a RIGHT JOIN clause and with to the query using the statistic relation
 * @method     ChildTaskQuery innerJoinWithstatistic() Adds a INNER JOIN clause and with to the query using the statistic relation
 *
 * @method     ChildTaskQuery leftJoinHint($relationAlias = null) Adds a LEFT JOIN clause to the query using the Hint relation
 * @method     ChildTaskQuery rightJoinHint($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Hint relation
 * @method     ChildTaskQuery innerJoinHint($relationAlias = null) Adds a INNER JOIN clause to the query using the Hint relation
 *
 * @method     ChildTaskQuery joinWithHint($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Hint relation
 *
 * @method     ChildTaskQuery leftJoinWithHint() Adds a LEFT JOIN clause and with to the query using the Hint relation
 * @method     ChildTaskQuery rightJoinWithHint() Adds a RIGHT JOIN clause and with to the query using the Hint relation
 * @method     ChildTaskQuery innerJoinWithHint() Adds a INNER JOIN clause and with to the query using the Hint relation
 *
 * @method     \CategoryQuery|\StatisticQuery|\HintQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTask findOne(ConnectionInterface $con = null) Return the first ChildTask matching the query
 * @method     ChildTask findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTask matching the query, or a new ChildTask object populated from the query conditions when no match is found
 *
 * @method     ChildTask findOneById(int $id) Return the first ChildTask filtered by the id column
 * @method     ChildTask findOneByCategoryId(int $category_id) Return the first ChildTask filtered by the category_id column
 * @method     ChildTask findOneByTitle(string $title) Return the first ChildTask filtered by the title column
 * @method     ChildTask findOneByDescription(string $description) Return the first ChildTask filtered by the description column
 * @method     ChildTask findOneByPoints(int $points) Return the first ChildTask filtered by the points column
 * @method     ChildTask findOneByFlag(string $flag) Return the first ChildTask filtered by the flag column
 * @method     ChildTask findOneByLogoLink(string $logo_link) Return the first ChildTask filtered by the logo_link column *

 * @method     ChildTask requirePk($key, ConnectionInterface $con = null) Return the ChildTask by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOne(ConnectionInterface $con = null) Return the first ChildTask matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTask requireOneById(int $id) Return the first ChildTask filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByCategoryId(int $category_id) Return the first ChildTask filtered by the category_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByTitle(string $title) Return the first ChildTask filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByDescription(string $description) Return the first ChildTask filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByPoints(int $points) Return the first ChildTask filtered by the points column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByFlag(string $flag) Return the first ChildTask filtered by the flag column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByLogoLink(string $logo_link) Return the first ChildTask filtered by the logo_link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTask[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTask objects based on current ModelCriteria
 * @method     ChildTask[]|ObjectCollection findById(int $id) Return ChildTask objects filtered by the id column
 * @method     ChildTask[]|ObjectCollection findByCategoryId(int $category_id) Return ChildTask objects filtered by the category_id column
 * @method     ChildTask[]|ObjectCollection findByTitle(string $title) Return ChildTask objects filtered by the title column
 * @method     ChildTask[]|ObjectCollection findByDescription(string $description) Return ChildTask objects filtered by the description column
 * @method     ChildTask[]|ObjectCollection findByPoints(int $points) Return ChildTask objects filtered by the points column
 * @method     ChildTask[]|ObjectCollection findByFlag(string $flag) Return ChildTask objects filtered by the flag column
 * @method     ChildTask[]|ObjectCollection findByLogoLink(string $logo_link) Return ChildTask objects filtered by the logo_link column
 * @method     ChildTask[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TaskQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TaskQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'jeopardy', $modelName = '\\Task', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTaskQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTaskQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTaskQuery) {
            return $criteria;
        }
        $query = new ChildTaskQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildTask|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TaskTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TaskTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTask A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, category_id, title, description, points, flag, logo_link FROM task WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildTask $obj */
            $obj = new ChildTask();
            $obj->hydrate($row);
            TaskTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildTask|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TaskTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TaskTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id > 12
     * </code>
     *
     * @see       filterByCategory()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the points column
     *
     * Example usage:
     * <code>
     * $query->filterByPoints(1234); // WHERE points = 1234
     * $query->filterByPoints(array(12, 34)); // WHERE points IN (12, 34)
     * $query->filterByPoints(array('min' => 12)); // WHERE points > 12
     * </code>
     *
     * @param     mixed $points The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByPoints($points = null, $comparison = null)
    {
        if (is_array($points)) {
            $useMinMax = false;
            if (isset($points['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_POINTS, $points['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($points['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_POINTS, $points['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_POINTS, $points, $comparison);
    }

    /**
     * Filter the query on the flag column
     *
     * Example usage:
     * <code>
     * $query->filterByFlag('fooValue');   // WHERE flag = 'fooValue'
     * $query->filterByFlag('%fooValue%'); // WHERE flag LIKE '%fooValue%'
     * </code>
     *
     * @param     string $flag The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByFlag($flag = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($flag)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $flag)) {
                $flag = str_replace('*', '%', $flag);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_FLAG, $flag, $comparison);
    }

    /**
     * Filter the query on the logo_link column
     *
     * Example usage:
     * <code>
     * $query->filterByLogoLink('fooValue');   // WHERE logo_link = 'fooValue'
     * $query->filterByLogoLink('%fooValue%'); // WHERE logo_link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $logoLink The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByLogoLink($logoLink = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($logoLink)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $logoLink)) {
                $logoLink = str_replace('*', '%', $logoLink);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_LOGO_LINK, $logoLink, $comparison);
    }

    /**
     * Filter the query by a related \Category object
     *
     * @param \Category|ObjectCollection $category The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTaskQuery The current query, for fluid interface
     */
    public function filterByCategory($category, $comparison = null)
    {
        if ($category instanceof \Category) {
            return $this
                ->addUsingAlias(TaskTableMap::COL_CATEGORY_ID, $category->getId(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TaskTableMap::COL_CATEGORY_ID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategory() only accepts arguments of type \Category or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Category relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function joinCategory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Category');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Category');
        }

        return $this;
    }

    /**
     * Use the Category relation Category object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CategoryQuery A secondary query class using the current class as primary query
     */
    public function useCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Category', '\CategoryQuery');
    }

    /**
     * Filter the query by a related \Statistic object
     *
     * @param \Statistic|ObjectCollection $statistic the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTaskQuery The current query, for fluid interface
     */
    public function filterBystatistic($statistic, $comparison = null)
    {
        if ($statistic instanceof \Statistic) {
            return $this
                ->addUsingAlias(TaskTableMap::COL_ID, $statistic->getTaskId(), $comparison);
        } elseif ($statistic instanceof ObjectCollection) {
            return $this
                ->usestatisticQuery()
                ->filterByPrimaryKeys($statistic->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBystatistic() only accepts arguments of type \Statistic or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the statistic relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function joinstatistic($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('statistic');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'statistic');
        }

        return $this;
    }

    /**
     * Use the statistic relation Statistic object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StatisticQuery A secondary query class using the current class as primary query
     */
    public function usestatisticQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinstatistic($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'statistic', '\StatisticQuery');
    }

    /**
     * Filter the query by a related \Hint object
     *
     * @param \Hint|ObjectCollection $hint the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTaskQuery The current query, for fluid interface
     */
    public function filterByHint($hint, $comparison = null)
    {
        if ($hint instanceof \Hint) {
            return $this
                ->addUsingAlias(TaskTableMap::COL_ID, $hint->getTask_id(), $comparison);
        } elseif ($hint instanceof ObjectCollection) {
            return $this
                ->useHintQuery()
                ->filterByPrimaryKeys($hint->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByHint() only accepts arguments of type \Hint or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Hint relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function joinHint($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Hint');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Hint');
        }

        return $this;
    }

    /**
     * Use the Hint relation Hint object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \HintQuery A secondary query class using the current class as primary query
     */
    public function useHintQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinHint($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Hint', '\HintQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTask $task Object to remove from the list of results
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function prune($task = null)
    {
        if ($task) {
            $this->addUsingAlias(TaskTableMap::COL_ID, $task->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the task table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TaskTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TaskTableMap::clearInstancePool();
            TaskTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TaskTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TaskTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TaskTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TaskTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TaskQuery
