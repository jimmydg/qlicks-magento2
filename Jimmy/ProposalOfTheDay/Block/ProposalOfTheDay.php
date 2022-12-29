<?php

declare(strict_types=1);

namespace Jimmy\ProposalOfTheDay\Block;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class ProposalOfTheDay extends Template
{
    public function showProposal(): ?Phrase
    {
        $proposalSku = $this->_scopeConfig->getValue(
            'proposaloftheday/proposaloftheday/proposal_sku',
            ScopeInterface::SCOPE_STORE
        );

        if (!$proposalSku) {
            return null;
        }

        return __(
            'Todays product proposal: %1',
            $proposalSku
        );
    }
}

