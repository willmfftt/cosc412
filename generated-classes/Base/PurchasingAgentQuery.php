<?php

namespace Base;

use \PurchasingAgent as ChildPurchasingAgent;
use \PurchasingAgentQuery as ChildPurchasingAgentQuery;
use \Exception;
use \PDO;
use Map\PurchasingAgentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'purchasing_agent' table.
 *
 *
 *
 * @method     ChildPurchasingAgentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPurchasingAgentQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildPurchasingAgentQuery orderByBranchId($order = Criteria::ASC) Order by the branch_id column
 *
 * @method     ChildPurchasingAgentQuery groupById() Group by the id column
 * @method     ChildPurchasingAgentQuery groupByUserId() Group by the user_id column
 * @method     ChildPurchasingAgentQuery groupByBranchId() Group by the branch_id column
 *
 * @method     ChildPurchasingAgentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPurchasingAgentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPurchasingAgentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPurchasingAgentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPurchasingAgentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPurchasingAgentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPurchasingAgentQuery leftJoinBranch($relationAlias = null) Adds a LEFT JOIN clause to the query using the Branch relation
 * @method     ChildPurchasingAgentQuery rightJoinBranch($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Branch relation
 * @method     ChildPurchasingAgentQuery innerJoinBranch($relationAlias = null) Adds a INNER JOIN clause to the query using the Branch relation
 *
 * @method     ChildPurchasingAgentQuery joinWithBranch($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Branch relation
 *
 * @method     ChildPurchasingAgentQuery leftJoinWithBranch() Adds a LEFT JOIN clause and with to the query using the Branch relation
 * @method     ChildPurchasingAgentQuery rightJoinWithBranch() Adds a RIGHT JOIN clause and with to the query using the Branch relation
 * @method     ChildPurchasingAgentQuery innerJoinWithBranch() Adds a INNER JOIN clause and with to the query using the Branch relation
 *
 * @method     ChildPurchasingAgentQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildPurchasingAgentQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildPurchasingAgentQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildPurchasingAgentQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildPurchasingAgentQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildPurchasingAgentQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildPurchasingAgentQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildPurchasingAgentQuery leftJoinTransaction($relationAlias = null) Adds a LEFT JOIN clause to the query using the Transaction relation
 * @method     ChildPurchasingAgentQuery rightJoinTransaction($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Transaction relation
 * @method     ChildPurchasingAgentQuery innerJoinTransaction($relationAlias = null) Adds a INNER JOIN clause to the query using the Transaction relation
 *
 * @method     ChildPurchasingAgentQuery joinWithTransaction($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Transaction relation
 *
 * @method     ChildPurchasingAgentQuery leftJoinWithTransaction() Adds a LEFT JOIN clause and with to the query using the Transaction relation
 * @method     ChildPurchasingAgentQuery rightJoinWithTransaction() Adds a RIGHT JOIN clause and with to the query using the Transaction relation
 * @method     ChildPurchasingAgentQuery innerJoinWithTransaction() Adds a INNER JOIN clause and with to the query using the Transaction relation
 *
 * @method     \BranchQuery|\UserQuery|\TransactionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPurchasingAgent findOne(ConnectionInterface $con = null) Return the first ChildPurchasingAgent matching the query
 * @method     ChildPurchasingAgent findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPurchasingAgent matching the query, or a new ChildPurchasingAgent object populated from the query conditions when no match is found
 *
 * @method     ChildPurchasingAgent findOneById(int $id) Return the first ChildPurchasingAgent filtered by the id column
 * @method     ChildPurchasingAgent findOneByUserId(int $user_id) Return the first ChildPurchasingAgent filtered by the user_id column
 * @method     ChildPurchasingAgent findOneByBranchId(int $branch_id) Return the first ChildPurchasingAgent filtered by the branch_id column *

 * @method     ChildPurchasingAgent requirePk($key, ConnectionInterface $con = null) Return the ChildPurchasingAgent by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPurchasingAgent requireOne(ConnectionInterface $con = null) Return the first ChildPurchasingAgent matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPurchasingAgent requireOneById(int $id) Return the first ChildPurchasingAgent filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPurchasingAgent requireOneByUserId(int $user_id) Return the first ChildPurchasingAgent filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPurchasingAgent requireOneByBranchId(int $branch_id) Return the first ChildPurchasingAgent filtered by the branch_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPurchasingAgent[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPurchasingAgent objects based on current ModelCriteria
 * @method     ChildPurchasingAgent[]|ObjectCollection findById(int $id) Return ChildPurchasingAgent objects filtered by the id column
 * @method     ChildPurchasingAgent[]|ObjectCollection findByUserId(int $user_id) Return ChildPurchasingAgent objects filtered by the user_id column
 * @method     ChildPurchasingAgent[]|ObjectCollection findByBranchId(int $branch_id) Return ChildPurchasingAgent objects filtered by the branch_id column
 * @method     ChildPurchasingAgent[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PurchasingAgentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PurchasingAgentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\PurchasingAgent', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPurchasingAgentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPurchasingAgentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPurchasingAgentQuery) {
            return $criteria;
        }
        $query = new ChildPurchasingAgentQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $user_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPurchasingAgent|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PurchasingAgentTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PurchasingAgentTableMap::DATABASE_NAME);
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
     * @return ChildPurchasingAgent A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, user_id, branch_id FROM purchasing_agent WHERE id = :p0 AND user_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPurchasingAgent $obj */
            $obj = new ChildPurchasingAgent();
            $obj->hydrate($row);
            PurchasingAgentTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildPurchasingAgent|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PurchasingAgentTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PurchasingAgentTableMap::COL_USER_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PurchasingAgentTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PurchasingAgentTableMap::COL_USER_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PurchasingAgentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PurchasingAgentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchasingAgentTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(PurchasingAgentTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(PurchasingAgentTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchasingAgentTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the branch_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBranchId(1234); // WHERE branch_id = 1234
     * $query->filterByBranchId(array(12, 34)); // WHERE branch_id IN (12, 34)
     * $query->filterByBranchId(array('min' => 12)); // WHERE branch_id > 12
     * </code>
     *
     * @see       filterByBranch()
     *
     * @param     mixed $branchId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function filterByBranchId($branchId = null, $comparison = null)
    {
        if (is_array($branchId)) {
            $useMinMax = false;
            if (isset($branchId['min'])) {
                $this->addUsingAlias(PurchasingAgentTableMap::COL_BRANCH_ID, $branchId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($branchId['max'])) {
                $this->addUsingAlias(PurchasingAgentTableMap::COL_BRANCH_ID, $branchId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchasingAgentTableMap::COL_BRANCH_ID, $branchId, $comparison);
    }

    /**
     * Filter the query by a related \Branch object
     *
     * @param \Branch|ObjectCollection $branch The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function filterByBranch($branch, $comparison = null)
    {
        if ($branch instanceof \Branch) {
            return $this
                ->addUsingAlias(PurchasingAgentTableMap::COL_BRANCH_ID, $branch->getId(), $comparison);
        } elseif ($branch instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PurchasingAgentTableMap::COL_BRANCH_ID, $branch->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPurchasingAgentQuery The current query, for fluid interface
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
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(PurchasingAgentTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PurchasingAgentTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
    }

    /**
     * Filter the query by a related \Transaction object
     *
     * @param \Transaction|ObjectCollection $transaction the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function filterByTransaction($transaction, $comparison = null)
    {
        if ($transaction instanceof \Transaction) {
            return $this
                ->addUsingAlias(PurchasingAgentTableMap::COL_ID, $transaction->getPurchasingAgentId(), $comparison);
        } elseif ($transaction instanceof ObjectCollection) {
            return $this
                ->useTransactionQuery()
                ->filterByPrimaryKeys($transaction->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTransaction() only accepts arguments of type \Transaction or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Transaction relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function joinTransaction($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Transaction');

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
            $this->addJoinObject($join, 'Transaction');
        }

        return $this;
    }

    /**
     * Use the Transaction relation Transaction object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TransactionQuery A secondary query class using the current class as primary query
     */
    public function useTransactionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTransaction($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Transaction', '\TransactionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPurchasingAgent $purchasingAgent Object to remove from the list of results
     *
     * @return $this|ChildPurchasingAgentQuery The current query, for fluid interface
     */
    public function prune($purchasingAgent = null)
    {
        if ($purchasingAgent) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PurchasingAgentTableMap::COL_ID), $purchasingAgent->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PurchasingAgentTableMap::COL_USER_ID), $purchasingAgent->getUserId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the purchasing_agent table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PurchasingAgentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PurchasingAgentTableMap::clearInstancePool();
            PurchasingAgentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PurchasingAgentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PurchasingAgentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PurchasingAgentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PurchasingAgentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PurchasingAgentQuery
