/**
 * @author Adam Charron <adam.c@vanillaforums.com>
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import { IUserFragment } from "@library/@types/api/users";
import { IRichQuoteRecord, RichQuote, QuoteResourceType } from "@library/content/embeds/RichQuote";
import { storiesOf } from "@storybook/react";
import React from "react";

const dummyUser: IUserFragment = {
    name: "Adam Charron",
    title: "Vanilla Staff",
    photoUrl: "https://us.v-cdn.net/5018160/uploads/userpics/809/nHZP3CA8JMR2H.jpg",
    userID: 4,
    dateLastActive: "2019-02-10T23:54:14+00:00",
};

const fullText = `
<p>
    Instructions to install, upgrade, and troubleshoot Vanilla are linked in the README file included in the download.
</p>
<p>
    For help troubleshooting, <strong>start a new discussion</strong> and include what steps you have already taken from our troubleshooting list.
</p>
<p>
    <strong>This is the FINAL release that will support PHP 7.0</strong>. It is our policy to drop support for PHP versions that have <a href="https://secure.php.net/supported-versions.php" rel="nofollow">ended security support</a> (PHP 7.0 support ended in December), and thus our next version will require PHP 7.1. (Note that the current PHP version is now 7.3 and we strongly recommend upgrading to it.)
</p>
<p>
    Support for Vanilla 2.6.x has now ended.
</p>`;

const quoteData: IRichQuoteRecord = {
    name: "Upgrade to latest vesion of Vanilla - Important security updates, bug fixes, and new features",
    body: `
    <p>
        Instructions to install, upgrade, and troubleshoot Vanilla are linked in the README file included in the download.
    </p>
    <p>
        For help troubleshooting, <strong>start a new discussion</strong> and include what steps you have already taken from our troubleshooting list.
    </p>`,
    hasLinesBefore: true,
    hasLinesAfter: true,
    url: "https://test.com",
    author: dummyUser,
    resourceType: QuoteResourceType.DISCUSSION,
    resourceID: 1,
    date: "2019-02-10T23:54:14+00:00",
};

storiesOf("@library/content/embeds/RichQuote", module)
    .add("Discussion", () => {
        const data = quoteData;
        return <RichQuote data={data} />;
    })
    .add("Comment", () => {
        const data = {
            ...quoteData,
            name: undefined,
            resourceType: QuoteResourceType.COMMENT,
        };
        return <RichQuote data={data} />;
    });
