<?php

namespace Base;

use \Location as ChildLocation;
use \LocationQuery as ChildLocationQuery;
use \Exception;
use \PDO;
use Map\LocationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'location' table.
 *
 *
 *
 * @method     ChildLocationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildLocationQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildLocationQuery orderByStateCode($order = Criteria::ASC) Order by the state_code column
 *
 * @method     ChildLocationQuery groupById() Group by the id column
 * @method     ChildLocationQuery groupByName() Group by the name column
 * @method     ChildLocationQuery groupByStateCode() Group by the state_code column
 *
 * @method     ChildLocationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLocationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLocationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLocationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLocationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLocationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLocationQuery leftJoinAuditor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Auditor relation
 * @method     ChildLocationQuery rightJoinAuditor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Auditor relation
 * @method     ChildLocationQuery innerJoinAuditor($relationAlias = null) Adds a INNER JOIN clause to the query using the Auditor relation
 *
 * @method     ChildLocationQuery joinWithAuditor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Auditor relation
 *
 * @method     ChildLocationQuery leftJoinWithAuditor() Adds a LEFT JOIN clause and with to the query using the Auditor relation
 * @method     ChildLocationQuery rightJoinWithAuditor() Adds a RIGHT JOIN clause and with to the query using the Auditor relation
 * @method     ChildLocationQuery innerJoinWithAuditor() Adds a INNER JOIN clause and with to the query using the Auditor relation
 *
 * @method     ChildLocationQuery leftJoinBranch($relationAlias = null) Adds a LEFT JOIN clause to the query using the Branch relation
 * @method     ChildLocationQuery rightJoinBranch($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Branch relation
 * @method     ChildLocationQuery innerJoinBranch($relationAlias = null) Adds a INNER JOIN clause to the query using the Branch relation
 *
 * @method     ChildLocationQuery joinWithBranch($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Branch relation
 *
 * @method     ChildLocationQuery leftJoinWithBranch() Adds a LEFT JOIN clause and with to the query using the Branch relation
 * @method     ChildLocationQuery rightJoinWithBranch() Adds a RIGHT JOIN clause and with to the query using the Branch relation
 * @method     ChildLocationQuery innerJoinWithBranch() Adds a INNER JOIN clause and with to the query using the Branch relation
 *
 * @method     ChildLocationQuery leftJoinBudget($relationAlias = null) Adds a LEFT JOIN clause to the query using the Budget relation
 * @method     ChildLocationQuery rightJoinBudget($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Budget relation
 * @method     ChildLocationQuery innerJoinBudget($relationAlias = null) Adds a INNER JOIN clause to the query using the Budget relation
 *
 * @method     ChildLocationQuery joinWithBudget($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Budget relation
 *
 * @method     ChildLocationQuery leftJoinWithBudget() Adds a LEFT JOIN clause and with to the query using the Budget relation
 * @method     ChildLocationQuery rightJoinWithBudget() Adds a RIGHT JOIN clause and with to the query using the Budget relation
 * @method     ChildLocationQuery innerJoinWithBudget() Adds a INNER JOIN clause and with to the query using the Budget relation
 *
 * @method     ChildLocationQuery leftJoinManager($relationAlias = null) Adds a LEFT JOIN clause to the query using the Manager relation
 * @method     ChildLocationQuery rightJoinManager($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Manager relation
 * @method     ChildLocationQuery innerJoinManager($relationAlias = null) Adds a INNER JOIN clause to the query using the Manager relation
 *
 * @method     ChildLocationQuery joinWithManager($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Manager relation
 *
 * @method     ChildLocationQuery leftJoinWithManager() Adds a LEFT JOIN clause and with to the query using the Manager relation
 * @method     ChildLocationQuery rightJoinWithManager() Adds a RIGHT JOIN clause and with to the query using the Manager relation
 * @method     ChildLocationQuery innerJoinWithManager() Adds a INNER JOIN clause and with to the query using the Manager relation
 *
 * @method     \AuditorQuery|\BranchQuery|\BudgetQuery|\ManagerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildLocation findOne(ConnectionInterface $con = null) Return the first ChildLocation matching the query
 * @method     ChildLocation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLocation matching the query, or a new ChildLocation object populated from the query conditions when no match is found
 *
 * @method     ChildLocation findOneById(int $id) Return the first ChildLocation filtered by the id column
 * @method     ChildLocation findOneByName(string $name) Return the first ChildLocation filtered by the name column
 * @method     ChildLocation findOneByStateCode(string $state_code) Return the first ChildLocation filtered by the state_code column *

 * @method     ChildLocation requirePk($key, ConnectionInterface $con = null) Return the ChildLocation by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOne(ConnectionInterface $con = null) Return the first ChildLocation matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLocation requireOneById(int $id) Return the first ChildLocation filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByName(string $name) Return the first ChildLocation filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByStateCode(string $state_code) Return the first ChildLocation filtered by the state_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLocation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLocation objects based on current ModelCriteria
 * @method     ChildLocation[]|ObjectCollection findById(int $id) Return ChildLocation objects filtered by the id column
 * @method     ChildLocation[]|ObjectCollection findByName(string $name) Return ChildLocation objects filtered by the name column
 * @method     ChildLocation[]|ObjectCollection findByStateCode(string $state_code) Return ChildLocation objects filtered by the state_code column
 * @method     ChildLocation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LocationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\LocationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Location', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLocationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLocationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLocationQuery) {
            return $criteria;
        }
        $query = new ChildLocationQuery();
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
     * @return ChildLocation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LocationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LocationTableMap::DATABASE_NAME);
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
     * @return ChildLocation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, state_code FROM location WHERE id = :p0';
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
            /** @var ChildLocation $obj */
            $obj = new ChildLocation();
            $obj->hydrate($row);
            LocationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildLocation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LocationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LocationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LocationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LocationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the state_code column
     *
     * Example usage:
     * <code>
     * $query->filterByStateCode('fooValue');   // WHERE state_code = 'fooValue'
     * $query->filterByStateCode('%fooValue%'); // WHERE state_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stateCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByStateCode($stateCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stateCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $stateCode)) {
                $stateCode = str_replace('*', '%', $stateCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_STATE_CODE, $stateCode, $comparison);
    }

    /**
     * Filter the query by a related \Auditor object
     *
     * @param \Auditor|ObjectCollection $auditor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLocationQuery The current query, for fluid interface
     */
    public function filterByAuditor($auditor, $comparison = null)
    {
        if ($auditor instanceof \Auditor) {
            return $this
                ->addUsingAlias(LocationTableMap::COL_ID, $auditor->getLocationId(), $comparison);
        } elseif ($auditor instanceof ObjectCollection) {
            return $this
                ->useAuditorQuery()
                ->filterByPrimaryKeys($auditor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuditor() only accepts arguments of type \Auditor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Auditor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function joinAuditor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Auditor');

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
            $this->addJoinObject($join, 'Auditor');
        }

        return $this;
    }

    /**
     * Use the Auditor relation Auditor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AuditorQuery A secondary query class using the current class as primary query
     */
    public function useAuditorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuditor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Auditor', '\AuditorQuery');
    }

    /**
     * Filter the query by a related \Branch object
     *
     * @param \Branch|ObjectCollection $branch the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLocationQuery The current query, for fluid interface
     */
    public function filterByBranch($branch, $comparison = null)
    {
        if ($branch instanceof \Branch) {
            return $this
                ->addUsingAlias(LocationTableMap::COL_ID, $branch->getLocationId(), $comparison);
        } elseif ($branch instanceof ObjectCollection) {
            return $this
                ->useBranchQuery()
                ->filterByPrimaryKeys($branch->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBranch() only accepts arguments of type \Branch or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Branch relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function joinBranch($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Branch');

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
            $this->addJoinObject($join, 'Branch');
        }

        return $this;
    }

    /**
     * Use the Branch relation Branch object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BranchQuery A secondary query class using the current class as primary query
     */
    public function useBranchQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBranch($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Branch', '\BranchQuery');
    }

    /**
     * Filter the query by a related \Budget object
     *
     * @param \Budget|ObjectCollection $budget the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLocationQuery The current query, for fluid interface
     */
    public function filterByBudget($budget, $comparison = null)
    {
        if ($budget instanceof \Budget) {
            return $this
                ->addUsingAlias(LocationTableMap::COL_ID, $budget->getLocationId(), $comparison);
        } elseif ($budget instanceof ObjectCollection) {
            return $this
                ->useBudgetQuery()
                ->filterByPrimaryKeys($budget->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBudget() only accepts arguments of type \Budget or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Budget relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function joinBudget($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Budget');

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
            $this->addJoinObject($join, 'Budget');
        }

        return $this;
    }

    /**
     * Use the Budget relation Budget object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BudgetQuery A secondary query class using the current class as primary query
     */
    public function useBudgetQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBudget($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Budget', '\BudgetQuery');
    }

    /**
     * Filter the query by a related \Manager object
     *
     * @param \Manager|ObjectCollection $manager the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLocationQuery The current query, for fluid interface
     */
    public function filterByManager($manager, $comparison = null)
    {
        if ($manager instanceof \Manager) {
            return $this
                ->addUsingAlias(LocationTableMap::COL_ID, $manager->getLocationId(), $comparison);
        } elseif ($manager instanceof ObjectCollection) {
            return $this
                ->useManagerQuery()
                ->filterByPrimaryKeys($manager->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByManager() only accepts arguments of type \Manager or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Manager relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function joinManager($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Manager');

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
            $this->addJoinObject($join, 'Manager');
        }

        return $this;
    }

    /**
     * Use the Manager relation Manager object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ManagerQuery A secondary query class using the current class as primary query
     */
    public function useManagerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinManager($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Manager', '\ManagerQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLocation $location Object to remove from the list of results
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function prune($location = null)
    {
        if ($location) {
            $this->addUsingAlias(LocationTableMap::COL_ID, $location->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the location table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LocationTableMap::clearInstancePool();
            LocationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LocationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LocationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LocationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // LocationQuery
