<?php

namespace Base;

use \Branch as ChildBranch;
use \BranchQuery as ChildBranchQuery;
use \Exception;
use \PDO;
use Map\BranchTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'branch' table.
 *
 *
 *
 * @method     ChildBranchQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBranchQuery orderByLocationId($order = Criteria::ASC) Order by the location_id column
 * @method     ChildBranchQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildBranchQuery groupById() Group by the id column
 * @method     ChildBranchQuery groupByLocationId() Group by the location_id column
 * @method     ChildBranchQuery groupByName() Group by the name column
 *
 * @method     ChildBranchQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBranchQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBranchQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBranchQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBranchQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBranchQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBranchQuery leftJoinLocation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Location relation
 * @method     ChildBranchQuery rightJoinLocation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Location relation
 * @method     ChildBranchQuery innerJoinLocation($relationAlias = null) Adds a INNER JOIN clause to the query using the Location relation
 *
 * @method     ChildBranchQuery joinWithLocation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Location relation
 *
 * @method     ChildBranchQuery leftJoinWithLocation() Adds a LEFT JOIN clause and with to the query using the Location relation
 * @method     ChildBranchQuery rightJoinWithLocation() Adds a RIGHT JOIN clause and with to the query using the Location relation
 * @method     ChildBranchQuery innerJoinWithLocation() Adds a INNER JOIN clause and with to the query using the Location relation
 *
 * @method     ChildBranchQuery leftJoinApprovedUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the ApprovedUser relation
 * @method     ChildBranchQuery rightJoinApprovedUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ApprovedUser relation
 * @method     ChildBranchQuery innerJoinApprovedUser($relationAlias = null) Adds a INNER JOIN clause to the query using the ApprovedUser relation
 *
 * @method     ChildBranchQuery joinWithApprovedUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ApprovedUser relation
 *
 * @method     ChildBranchQuery leftJoinWithApprovedUser() Adds a LEFT JOIN clause and with to the query using the ApprovedUser relation
 * @method     ChildBranchQuery rightJoinWithApprovedUser() Adds a RIGHT JOIN clause and with to the query using the ApprovedUser relation
 * @method     ChildBranchQuery innerJoinWithApprovedUser() Adds a INNER JOIN clause and with to the query using the ApprovedUser relation
 *
 * @method     ChildBranchQuery leftJoinBudget($relationAlias = null) Adds a LEFT JOIN clause to the query using the Budget relation
 * @method     ChildBranchQuery rightJoinBudget($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Budget relation
 * @method     ChildBranchQuery innerJoinBudget($relationAlias = null) Adds a INNER JOIN clause to the query using the Budget relation
 *
 * @method     ChildBranchQuery joinWithBudget($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Budget relation
 *
 * @method     ChildBranchQuery leftJoinWithBudget() Adds a LEFT JOIN clause and with to the query using the Budget relation
 * @method     ChildBranchQuery rightJoinWithBudget() Adds a RIGHT JOIN clause and with to the query using the Budget relation
 * @method     ChildBranchQuery innerJoinWithBudget() Adds a INNER JOIN clause and with to the query using the Budget relation
 *
 * @method     ChildBranchQuery leftJoinPurchasingAgent($relationAlias = null) Adds a LEFT JOIN clause to the query using the PurchasingAgent relation
 * @method     ChildBranchQuery rightJoinPurchasingAgent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PurchasingAgent relation
 * @method     ChildBranchQuery innerJoinPurchasingAgent($relationAlias = null) Adds a INNER JOIN clause to the query using the PurchasingAgent relation
 *
 * @method     ChildBranchQuery joinWithPurchasingAgent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PurchasingAgent relation
 *
 * @method     ChildBranchQuery leftJoinWithPurchasingAgent() Adds a LEFT JOIN clause and with to the query using the PurchasingAgent relation
 * @method     ChildBranchQuery rightJoinWithPurchasingAgent() Adds a RIGHT JOIN clause and with to the query using the PurchasingAgent relation
 * @method     ChildBranchQuery innerJoinWithPurchasingAgent() Adds a INNER JOIN clause and with to the query using the PurchasingAgent relation
 *
 * @method     ChildBranchQuery leftJoinSupervisor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Supervisor relation
 * @method     ChildBranchQuery rightJoinSupervisor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Supervisor relation
 * @method     ChildBranchQuery innerJoinSupervisor($relationAlias = null) Adds a INNER JOIN clause to the query using the Supervisor relation
 *
 * @method     ChildBranchQuery joinWithSupervisor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Supervisor relation
 *
 * @method     ChildBranchQuery leftJoinWithSupervisor() Adds a LEFT JOIN clause and with to the query using the Supervisor relation
 * @method     ChildBranchQuery rightJoinWithSupervisor() Adds a RIGHT JOIN clause and with to the query using the Supervisor relation
 * @method     ChildBranchQuery innerJoinWithSupervisor() Adds a INNER JOIN clause and with to the query using the Supervisor relation
 *
 * @method     \LocationQuery|\ApprovedUserQuery|\BudgetQuery|\PurchasingAgentQuery|\SupervisorQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBranch findOne(ConnectionInterface $con = null) Return the first ChildBranch matching the query
 * @method     ChildBranch findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBranch matching the query, or a new ChildBranch object populated from the query conditions when no match is found
 *
 * @method     ChildBranch findOneById(int $id) Return the first ChildBranch filtered by the id column
 * @method     ChildBranch findOneByLocationId(int $location_id) Return the first ChildBranch filtered by the location_id column
 * @method     ChildBranch findOneByName(string $name) Return the first ChildBranch filtered by the name column *

 * @method     ChildBranch requirePk($key, ConnectionInterface $con = null) Return the ChildBranch by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBranch requireOne(ConnectionInterface $con = null) Return the first ChildBranch matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBranch requireOneById(int $id) Return the first ChildBranch filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBranch requireOneByLocationId(int $location_id) Return the first ChildBranch filtered by the location_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBranch requireOneByName(string $name) Return the first ChildBranch filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBranch[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBranch objects based on current ModelCriteria
 * @method     ChildBranch[]|ObjectCollection findById(int $id) Return ChildBranch objects filtered by the id column
 * @method     ChildBranch[]|ObjectCollection findByLocationId(int $location_id) Return ChildBranch objects filtered by the location_id column
 * @method     ChildBranch[]|ObjectCollection findByName(string $name) Return ChildBranch objects filtered by the name column
 * @method     ChildBranch[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BranchQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BranchQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Branch', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBranchQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBranchQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBranchQuery) {
            return $criteria;
        }
        $query = new ChildBranchQuery();
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
     * @return ChildBranch|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BranchTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BranchTableMap::DATABASE_NAME);
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
     * @return ChildBranch A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, location_id, name FROM branch WHERE id = :p0';
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
            /** @var ChildBranch $obj */
            $obj = new ChildBranch();
            $obj->hydrate($row);
            BranchTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBranch|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BranchTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BranchTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BranchTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BranchTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BranchTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the location_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationId(1234); // WHERE location_id = 1234
     * $query->filterByLocationId(array(12, 34)); // WHERE location_id IN (12, 34)
     * $query->filterByLocationId(array('min' => 12)); // WHERE location_id > 12
     * </code>
     *
     * @see       filterByLocation()
     *
     * @param     mixed $locationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function filterByLocationId($locationId = null, $comparison = null)
    {
        if (is_array($locationId)) {
            $useMinMax = false;
            if (isset($locationId['min'])) {
                $this->addUsingAlias(BranchTableMap::COL_LOCATION_ID, $locationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($locationId['max'])) {
                $this->addUsingAlias(BranchTableMap::COL_LOCATION_ID, $locationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BranchTableMap::COL_LOCATION_ID, $locationId, $comparison);
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
     * @return $this|ChildBranchQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BranchTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \Location object
     *
     * @param \Location|ObjectCollection $location The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBranchQuery The current query, for fluid interface
     */
    public function filterByLocation($location, $comparison = null)
    {
        if ($location instanceof \Location) {
            return $this
                ->addUsingAlias(BranchTableMap::COL_LOCATION_ID, $location->getId(), $comparison);
        } elseif ($location instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BranchTableMap::COL_LOCATION_ID, $location->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByLocation() only accepts arguments of type \Location or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Location relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function joinLocation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Location');

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
            $this->addJoinObject($join, 'Location');
        }

        return $this;
    }

    /**
     * Use the Location relation Location object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \LocationQuery A secondary query class using the current class as primary query
     */
    public function useLocationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLocation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Location', '\LocationQuery');
    }

    /**
     * Filter the query by a related \ApprovedUser object
     *
     * @param \ApprovedUser|ObjectCollection $approvedUser the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBranchQuery The current query, for fluid interface
     */
    public function filterByApprovedUser($approvedUser, $comparison = null)
    {
        if ($approvedUser instanceof \ApprovedUser) {
            return $this
                ->addUsingAlias(BranchTableMap::COL_ID, $approvedUser->getBranchId(), $comparison);
        } elseif ($approvedUser instanceof ObjectCollection) {
            return $this
                ->useApprovedUserQuery()
                ->filterByPrimaryKeys($approvedUser->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByApprovedUser() only accepts arguments of type \ApprovedUser or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ApprovedUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function joinApprovedUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ApprovedUser');

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
            $this->addJoinObject($join, 'ApprovedUser');
        }

        return $this;
    }

    /**
     * Use the ApprovedUser relation ApprovedUser object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ApprovedUserQuery A secondary query class using the current class as primary query
     */
    public function useApprovedUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinApprovedUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ApprovedUser', '\ApprovedUserQuery');
    }

    /**
     * Filter the query by a related \Budget object
     *
     * @param \Budget|ObjectCollection $budget the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBranchQuery The current query, for fluid interface
     */
    public function filterByBudget($budget, $comparison = null)
    {
        if ($budget instanceof \Budget) {
            return $this
                ->addUsingAlias(BranchTableMap::COL_ID, $budget->getBranchId(), $comparison);
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
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function joinBudget($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useBudgetQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBudget($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Budget', '\BudgetQuery');
    }

    /**
     * Filter the query by a related \PurchasingAgent object
     *
     * @param \PurchasingAgent|ObjectCollection $purchasingAgent the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBranchQuery The current query, for fluid interface
     */
    public function filterByPurchasingAgent($purchasingAgent, $comparison = null)
    {
        if ($purchasingAgent instanceof \PurchasingAgent) {
            return $this
                ->addUsingAlias(BranchTableMap::COL_ID, $purchasingAgent->getBranchId(), $comparison);
        } elseif ($purchasingAgent instanceof ObjectCollection) {
            return $this
                ->usePurchasingAgentQuery()
                ->filterByPrimaryKeys($purchasingAgent->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPurchasingAgent() only accepts arguments of type \PurchasingAgent or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PurchasingAgent relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function joinPurchasingAgent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PurchasingAgent');

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
            $this->addJoinObject($join, 'PurchasingAgent');
        }

        return $this;
    }

    /**
     * Use the PurchasingAgent relation PurchasingAgent object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PurchasingAgentQuery A secondary query class using the current class as primary query
     */
    public function usePurchasingAgentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPurchasingAgent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PurchasingAgent', '\PurchasingAgentQuery');
    }

    /**
     * Filter the query by a related \Supervisor object
     *
     * @param \Supervisor|ObjectCollection $supervisor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBranchQuery The current query, for fluid interface
     */
    public function filterBySupervisor($supervisor, $comparison = null)
    {
        if ($supervisor instanceof \Supervisor) {
            return $this
                ->addUsingAlias(BranchTableMap::COL_ID, $supervisor->getBranchId(), $comparison);
        } elseif ($supervisor instanceof ObjectCollection) {
            return $this
                ->useSupervisorQuery()
                ->filterByPrimaryKeys($supervisor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySupervisor() only accepts arguments of type \Supervisor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Supervisor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function joinSupervisor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Supervisor');

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
            $this->addJoinObject($join, 'Supervisor');
        }

        return $this;
    }

    /**
     * Use the Supervisor relation Supervisor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SupervisorQuery A secondary query class using the current class as primary query
     */
    public function useSupervisorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSupervisor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Supervisor', '\SupervisorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBranch $branch Object to remove from the list of results
     *
     * @return $this|ChildBranchQuery The current query, for fluid interface
     */
    public function prune($branch = null)
    {
        if ($branch) {
            $this->addUsingAlias(BranchTableMap::COL_ID, $branch->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the branch table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BranchTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BranchTableMap::clearInstancePool();
            BranchTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BranchTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BranchTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BranchTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BranchTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BranchQuery
