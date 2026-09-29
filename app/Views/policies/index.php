<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      HR Policies, Circulars &amp; Employee Handbook
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Access official corporate policies, compliance guidelines, code of conduct, and sign digital acknowledgements.
    </p>
  </div>
</div>

<div class="grid-2">
  <?php foreach ($policies as $pol): ?>
    <div class="card" style="border-left: 4px solid var(--color-primary); display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
          <div>
            <span class="badge badge-info" style="font-size: 11px; text-transform: uppercase;">
              <?= esc(str_replace('_', ' ', $pol['category'])) ?>
            </span>
            <span style="font-size: 12px; color: var(--color-slate-400); margin-left: 6px;">v<?= esc($pol['version']) ?></span>
          </div>
          <?php if (!empty($pol['is_acknowledged'])): ?>
            <span class="badge badge-success">&#10003; Acknowledged</span>
          <?php else: ?>
            <span class="badge badge-warning">Signature Pending</span>
          <?php endif; ?>
        </div>

        <h3 style="font-size: 16.5px; font-weight: 700; margin-bottom: 6px;"><?= esc($pol['title']) ?></h3>
        <p style="font-size: 13px; color: var(--color-slate-600); margin-bottom: 12px;">
          <?= esc($pol['summary']) ?>
        </p>

        <?php if (!empty($pol['content'])): ?>
          <div style="background: var(--color-slate-50); padding: 12px; border-radius: 6px; font-size: 12.5px; margin-bottom: 14px; max-height: 120px; overflow-y: auto;">
            <?= $pol['content'] ?>
          </div>
        <?php endif; ?>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-slate-100); padding-top: 12px; margin-top: 12px;">
        <span style="font-size: 12px; color: var(--color-slate-400);">
          Effective: <?= date('M j, Y', strtotime($pol['effective_date'])) ?>
        </span>

        <?php if (empty($pol['is_acknowledged'])): ?>
          <a href="<?= site_url('policies/acknowledge/' . $pol['id']) ?>" 
             class="btn btn-primary btn-sm"
             onclick="return confirm('Do you digitally acknowledge and agree to comply with this policy?')">
            I Acknowledge &amp; Accept
          </a>
        <?php else: ?>
          <span style="font-size: 12px; color: var(--color-emerald-600); font-weight: 600;">
            Signed on <?= date('M j, Y', strtotime($pol['acknowledged_at'])) ?>
          </span>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
