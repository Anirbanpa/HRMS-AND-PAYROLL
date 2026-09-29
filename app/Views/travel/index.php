<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Expense &amp; Travel Management
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Corporate travel requests, pre-trip budget advances, itemized receipt claims, and manager/finance settlement authorizations.
    </p>
  </div>
  <div style="display: flex; gap: 10px; flex-wrap: wrap;">
    <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalFileClaim').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
      File Expense Claim
    </button>
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalApplyTravel').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      New Travel Request
    </button>
  </div>
</div>

<!-- EXECUTIVE STAT CARDS -->
<div class="grid-4" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Total Travel Trips</div>
      <div class="stat-value"><?= count($trips) ?></div>
      <div class="stat-subtext">Business authorizations</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/></svg>
    </div>
  </div>

  <div class="stat-card emerald">
    <div class="stat-content">
      <div class="stat-label">Approved Travel Budget</div>
      <div class="stat-value">₹<?= number_format($totalApprovedBudget, 2) ?></div>
      <div class="stat-subtext">Sanctioned company limit</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
    </div>
  </div>

  <div class="stat-card sky">
    <div class="stat-content">
      <div class="stat-label">Expense Claims Settled</div>
      <div class="stat-value">₹<?= number_format($totalClaimsSettled, 2) ?></div>
      <div class="stat-subtext">Reimbursed or credited</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
  </div>

  <div class="stat-card amber">
    <div class="stat-content">
      <div class="stat-label">Pending Authorizations</div>
      <div class="stat-value"><?= $pendingTripsCount + $pendingClaimsCount ?></div>
      <div class="stat-subtext"><?= $pendingTripsCount ?> trips &bull; <?= $pendingClaimsCount ?> claims</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
  </div>
</div>

<!-- Tabs Navigation -->
<div style="display: flex; border-bottom: 2px solid var(--color-slate-200); margin-bottom: 24px; gap: 20px;">
  <a href="<?= site_url('travel?tab=trips') ?>" style="padding: 10px 4px; font-weight: <?= ($activeTab !== 'claims') ? '700' : '600' ?>; font-size: 14px; text-decoration: none; border-bottom: 2px solid <?= ($activeTab !== 'claims') ? 'var(--color-primary)' : 'transparent' ?>; margin-bottom: -2px; color: <?= ($activeTab !== 'claims') ? 'var(--color-primary)' : 'var(--color-slate-500)' ?>;">
    Travel Authorizations &amp; Trips (<?= count($trips) ?>)
  </a>
  <a href="<?= site_url('travel?tab=claims') ?>" style="padding: 10px 4px; font-weight: <?= ($activeTab === 'claims') ? '700' : '600' ?>; font-size: 14px; text-decoration: none; border-bottom: 2px solid <?= ($activeTab === 'claims') ? 'var(--color-primary)' : 'transparent' ?>; margin-bottom: -2px; color: <?= ($activeTab === 'claims') ? 'var(--color-primary)' : 'var(--color-slate-500)' ?>;">
    Itemized Expense Claims &amp; Settlements (<?= count($claims) ?>)
  </a>
</div>

<?php if ($activeTab !== 'claims'): ?>
<!-- TAB 1: TRAVEL TRIPS REGISTER -->
<div class="card" style="padding: 0; overflow: hidden;">
  <div style="padding: 16px 20px; background: var(--color-slate-50); border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center;">
    <h3 style="font-size: 15px; font-weight: 700; color: var(--color-slate-800);">Business Travel Requests &amp; Advance Disbursements</h3>
    <span class="badge badge-secondary"><?= count($trips) ?> Total Requests</span>
  </div>

  <div style="overflow-x: auto;">
    <table class="table" style="width: 100%; font-size: 13px;">
      <thead>
        <tr>
          <th>Request No &amp; Purpose</th>
          <th>Employee</th>
          <th>Route &amp; Mode</th>
          <th>Travel Dates</th>
          <th>Budget &amp; Advance</th>
          <th>Status</th>
          <?php if ($isFinance): ?>
            <th style="text-align: right;">Action</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($trips)): ?>
          <tr><td colspan="7" style="text-align: center; color: var(--color-slate-500); padding: 36px;">No travel applications recorded. Click 'New Travel Request' to submit an itinerary.</td></tr>
        <?php else: ?>
          <?php foreach ($trips as $tr): ?>
            <tr>
              <td>
                <div style="font-weight: 700; color: var(--color-slate-900);"><?= esc($tr['purpose']) ?></div>
                <div style="font-size: 11.5px; color: var(--color-slate-500);">
                  <code><?= esc($tr['request_number']) ?></code> &bull; <?= esc(ucfirst($tr['travel_type'])) ?>
                </div>
              </td>
              <td>
                <div style="font-weight: 600; color: var(--color-slate-800);"><?= esc($tr['first_name'] . ' ' . $tr['last_name']) ?></div>
                <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($tr['employee_code']) ?> &bull; <?= esc($tr['department_name'] ?? 'General') ?></div>
              </td>
              <td>
                <div style="font-weight: 600; color: var(--color-slate-800);"><?= esc($tr['source_city']) ?> &rarr; <?= esc($tr['destination_city']) ?></div>
              </td>
              <td>
                <div><?= date('M j', strtotime($tr['start_date'])) ?> &ndash; <?= date('M j, Y', strtotime($tr['end_date'])) ?></div>
              </td>
              <td>
                <div><strong>₹<?= number_format((float)$tr['estimated_budget'], 2) ?></strong></div>
                <?php if ((float)$tr['advance_required'] > 0): ?>
                  <div style="font-size: 11.5px; color: var(--color-amber-600);">
                    Adv: ₹<?= number_format((float)$tr['advance_required'], 2) ?>
                    <?php if ((float)$tr['advance_disbursed'] > 0): ?>
                      (Disbursed: ₹<?= number_format((float)$tr['advance_disbursed'], 2) ?>)
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($tr['status'] === 'submitted'): ?>
                  <span class="badge badge-warning">Awaiting Approval</span>
                <?php elseif (in_array($tr['status'], ['approved', 'manager_approved', 'finance_approved'], true)): ?>
                  <span class="badge badge-success">Approved</span>
                <?php elseif ($tr['status'] === 'rejected'): ?>
                  <span class="badge badge-danger">Rejected</span>
                <?php else: ?>
                  <span class="badge badge-secondary"><?= esc(ucfirst($tr['status'])) ?></span>
                <?php endif; ?>
              </td>
              <?php if ($isFinance): ?>
                <td style="text-align: right; white-space: nowrap;">
                  <?php if ($tr['status'] === 'submitted'): ?>
                    <button type="button" class="btn btn-primary btn-sm" onclick='openApproveTripModal(<?= json_encode($tr) ?>)' style="padding: 3px 8px; font-size: 11px;">
                      Approve
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick='openRejectTripModal(<?= json_encode($tr) ?>)' style="padding: 3px 8px; font-size: 11px; color: var(--color-danger);">
                      Reject
                    </button>
                  <?php else: ?>
                    <span style="font-size: 11.5px; color: var(--color-slate-400);">Processed</span>
                  <?php endif; ?>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php else: ?>
<!-- TAB 2: ITEMIZED EXPENSE CLAIMS & SETTLEMENTS -->
<div class="card" style="padding: 0; overflow: hidden;">
  <div style="padding: 16px 20px; background: var(--color-slate-50); border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h3 style="font-size: 15px; font-weight: 700; color: var(--color-slate-800);">Itemized Travel Expense Claims &amp; Receipts</h3>
      <p style="font-size: 12.5px; color: var(--color-slate-500);">Lodging, flights, local conveyance, meals, and incidental reimbursement claims.</p>
    </div>
    <span class="badge badge-secondary"><?= count($claims) ?> Claims</span>
  </div>

  <div style="overflow-x: auto;">
    <table class="table" style="width: 100%; font-size: 13px;">
      <thead>
        <tr>
          <th>Claim Details &amp; Category</th>
          <th>Employee</th>
          <th>Linked Travel Request</th>
          <th>Bill Date &amp; Invoice</th>
          <th>Claim Amount</th>
          <th>Approved Amount</th>
          <th>Status</th>
          <?php if ($isFinance): ?>
            <th style="text-align: right;">Action</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($claims)): ?>
          <tr><td colspan="8" style="text-align: center; color: var(--color-slate-500); padding: 36px;">No expense claims filed yet. Click 'File Expense Claim' above to submit bills.</td></tr>
        <?php else: ?>
          <?php foreach ($claims as $cl): ?>
            <tr>
              <td>
                <div style="font-weight: 700; color: var(--color-slate-900);"><?= esc($cl['expense_category']) ?></div>
                <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($cl['remarks'] ?? 'No notes provided') ?></div>
              </td>
              <td>
                <div style="font-weight: 600; color: var(--color-slate-800);"><?= esc($cl['first_name'] . ' ' . $cl['last_name']) ?></div>
                <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($cl['employee_code']) ?></div>
              </td>
              <td>
                <?php if (!empty($cl['request_number'])): ?>
                  <code><?= esc($cl['request_number']) ?></code>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($cl['trip_purpose']) ?></div>
                <?php else: ?>
                  <span style="color: var(--color-slate-400);">Non-trip Direct Expense</span>
                <?php endif; ?>
              </td>
              <td>
                <div><?= date('M j, Y', strtotime($cl['bill_date'])) ?></div>
                <div style="font-size: 11px; color: var(--color-slate-500);">Inv: <?= esc($cl['bill_number']) ?></div>
              </td>
              <td>
                <strong>₹<?= number_format((float)$cl['amount'], 2) ?></strong>
              </td>
              <td>
                <strong style="color: var(--color-success);">
                  ₹<?= number_format((float)($cl['approved_amount'] ?: $cl['amount']), 2) ?>
                </strong>
              </td>
              <td>
                <?php if ($cl['status'] === 'submitted'): ?>
                  <span class="badge badge-warning">Under Review</span>
                <?php elseif ($cl['status'] === 'approved'): ?>
                  <span class="badge badge-success">Approved</span>
                <?php elseif ($cl['status'] === 'reimbursed'): ?>
                  <span class="badge badge-info">Reimbursed</span>
                <?php elseif ($cl['status'] === 'rejected'): ?>
                  <span class="badge badge-danger">Rejected</span>
                <?php else: ?>
                  <span class="badge badge-secondary"><?= esc(ucfirst($cl['status'])) ?></span>
                <?php endif; ?>
              </td>
              <?php if ($isFinance): ?>
                <td style="text-align: right;">
                  <?php if ($cl['status'] === 'submitted'): ?>
                    <button type="button" class="btn btn-primary btn-sm" onclick='openSettleClaimModal(<?= json_encode($cl) ?>)' style="padding: 3px 8px; font-size: 11px;">
                      Settle Claim
                    </button>
                  <?php else: ?>
                    <span style="font-size: 11.5px; color: var(--color-slate-400);">Settled</span>
                  <?php endif; ?>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>

<!-- MODAL: APPLY TRAVEL -->
<div id="modalApplyTravel" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 520px; max-width: 90vw; max-height: 90vh; overflow-y: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Submit Business Travel Authorization</h3>
      <button type="button" onclick="document.getElementById('modalApplyTravel').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('travel/apply') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Business Purpose *</label>
        <input type="text" name="purpose" class="form-control" placeholder="e.g. Quarterly Client Architecture &amp; Delivery Review" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Source City *</label>
          <input type="text" name="source_city" class="form-control" placeholder="e.g. Mumbai" required>
        </div>
        <div class="form-group">
          <label class="form-label">Destination City *</label>
          <input type="text" name="destination_city" class="form-control" placeholder="e.g. Bengaluru" required>
        </div>
      </div>

      <div class="grid-3" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Travel Type</label>
          <select name="travel_type" class="form-control">
            <option value="domestic">Domestic</option>
            <option value="international">International</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Start Date *</label>
          <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d', strtotime('+3 days')) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">End Date *</label>
          <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+6 days')) ?>" required>
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Estimated Budget (₹)</label>
          <input type="number" step="0.01" name="estimated_budget" class="form-control" placeholder="15000.00">
        </div>
        <div class="form-group">
          <label class="form-label">Advance Required (₹)</label>
          <input type="number" step="0.01" name="advance_required" class="form-control" placeholder="5000.00">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Itinerary &amp; Notes</label>
        <textarea name="notes" class="form-control" rows="2" placeholder="Flight preferences, meeting venues, or hotel accommodation needs"></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalApplyTravel').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit Travel Authorization</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: FILE EXPENSE CLAIM -->
<div id="modalFileClaim" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 520px; max-width: 90vw; max-height: 90vh; overflow-y: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">File Itemized Expense Claim</h3>
      <button type="button" onclick="document.getElementById('modalFileClaim').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('travel/claim') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Linked Travel Authorization (Optional)</label>
        <select name="travel_request_id" class="form-control">
          <option value="">-- Direct Claim (No Travel Authorization Linked) --</option>
          <?php foreach ($myEligibleTrips as $tr): ?>
            <option value="<?= $tr['id'] ?>">
              <?= esc($tr['request_number']) ?> &ndash; <?= esc($tr['purpose']) ?> (<?= esc($tr['source_city']) ?> to <?= esc($tr['destination_city']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Expense Category *</label>
          <select name="expense_category" class="form-control" required>
            <option value="Flight / Airfare">Flight / Airfare</option>
            <option value="Train / Bus Fare">Train / Bus Fare</option>
            <option value="Hotel &amp; Lodging">Hotel &amp; Lodging</option>
            <option value="Meals &amp; Per-Diem">Meals &amp; Per-Diem</option>
            <option value="Local Transit / Taxi">Local Transit / Taxi</option>
            <option value="Client Entertainment">Client Entertainment</option>
            <option value="Miscellaneous">Miscellaneous</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Bill / Invoice Date *</label>
          <input type="date" name="bill_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Claim Amount (₹) *</label>
          <input type="number" step="0.01" min="1" name="amount" class="form-control" placeholder="2500.00" required>
        </div>
        <div class="form-group">
          <label class="form-label">Invoice / Receipt No</label>
          <input type="text" name="bill_number" class="form-control" placeholder="e.g. TAX-INV-98421">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Expense Description &amp; Justification</label>
        <textarea name="remarks" class="form-control" rows="2" placeholder="e.g. Airport cab ride + hotel room invoice for 2 nights"></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalFileClaim').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit Claim for Settlement</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: APPROVE TRIP -->
<div id="modalApproveTrip" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 480px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
      <h3 style="font-size: 18px; font-weight: 700;">Approve Travel Authorization</h3>
      <button type="button" onclick="document.getElementById('modalApproveTrip').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <div style="padding: 10px; background: var(--color-slate-50); border-radius: 6px; font-size: 13px; margin-bottom: 14px;">
      <div>Trip: <strong id="appr_trip_purpose"></strong></div>
      <div>Employee: <strong id="appr_trip_emp"></strong></div>
      <div>Requested Advance: <strong id="appr_trip_adv" style="color: var(--color-amber-600);"></strong></div>
    </div>

    <form id="formApproveTrip" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label">Advance Amount Disbursed (₹)</label>
        <input type="number" step="0.01" name="advance_disbursed" id="appr_adv_disbursed" class="form-control">
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Approval Remarks</label>
        <input type="text" name="remarks" class="form-control" value="Travel and travel advance approved.">
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalApproveTrip').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Confirm Travel Approval</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: REJECT TRIP -->
<div id="modalRejectTrip" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 460px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
      <h3 style="font-size: 18px; font-weight: 700;">Decline Travel Request</h3>
      <button type="button" onclick="document.getElementById('modalRejectTrip').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form id="formRejectTrip" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Reason for Rejection *</label>
        <textarea name="remarks" class="form-control" rows="3" placeholder="e.g. Non-essential travel; please conduct via video conference." required></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalRejectTrip').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-danger" style="background: var(--color-danger); color: #fff; border: none;">Reject Request</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: SETTLE EXPENSE CLAIM -->
<div id="modalSettleClaim" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 480px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
      <h3 style="font-size: 18px; font-weight: 700;">Settle Travel Expense Claim</h3>
      <button type="button" onclick="document.getElementById('modalSettleClaim').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <div style="padding: 10px; background: var(--color-slate-50); border-radius: 6px; font-size: 13px; margin-bottom: 14px;">
      <div>Claim Category: <strong id="settle_cat"></strong></div>
      <div>Employee: <strong id="settle_emp"></strong></div>
      <div>Claimed Amount: <strong id="settle_claimed_amt" style="color: var(--color-slate-900);"></strong></div>
    </div>

    <form id="formSettleClaim" method="POST">
      <?= csrf_field() ?>
      <div class="grid-2" style="margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label">Settlement Action *</label>
          <select name="status" class="form-control" required>
            <option value="approved">Approve for Reimbursement</option>
            <option value="reimbursed">Mark Already Reimbursed / Paid</option>
            <option value="rejected">Reject Claim</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Approved Amount (₹) *</label>
          <input type="number" step="0.01" name="approved_amount" id="settle_appr_amt" class="form-control" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Finance Settlement Remarks</label>
        <input type="text" name="remarks" class="form-control" value="Verified against submitted receipt vouchers.">
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalSettleClaim').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Process Settlement</button>
      </div>
    </form>
  </div>
</div>

<script>
function openApproveTripModal(tr) {
  document.getElementById('appr_trip_purpose').textContent = tr.purpose;
  document.getElementById('appr_trip_emp').textContent = tr.first_name + ' ' + tr.last_name + ' (' + tr.employee_code + ')';
  document.getElementById('appr_trip_adv').textContent = '₹' + parseFloat(tr.advance_required || 0).toFixed(2);
  document.getElementById('appr_adv_disbursed').value = tr.advance_required || 0;
  document.getElementById('formApproveTrip').action = '<?= site_url("travel/approve/") ?>' + tr.id;
  document.getElementById('modalApproveTrip').style.display = 'flex';
}

function openRejectTripModal(tr) {
  document.getElementById('formRejectTrip').action = '<?= site_url("travel/reject/") ?>' + tr.id;
  document.getElementById('modalRejectTrip').style.display = 'flex';
}

function openSettleClaimModal(cl) {
  document.getElementById('settle_cat').textContent = cl.expense_category;
  document.getElementById('settle_emp').textContent = cl.first_name + ' ' + cl.last_name + ' (' + cl.employee_code + ')';
  document.getElementById('settle_claimed_amt').textContent = '₹' + parseFloat(cl.amount).toFixed(2);
  document.getElementById('settle_appr_amt').value = cl.amount;
  document.getElementById('formSettleClaim').action = '<?= site_url("travel/claim/approve/") ?>' + cl.id;
  document.getElementById('modalSettleClaim').style.display = 'flex';
}
</script>
