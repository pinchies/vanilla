/**
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import React from "react";
import { IUserFragment } from "@library/@types/api/users";
import { LoadStatus, ILoadable } from "@library/@types/api/core";
import { richQuoteClasses } from "@library/content/embeds/richQuoteStyles";
import ProfileLink from "@library/navigation/ProfileLink";
import SmartLink from "@library/routing/links/SmartLink";
import { userContentClasses } from "@library/content/userContentStyles";
import classNames from "classnames";
import DateTime from "@library/content/DateTime";
import { metasClasses } from "@library/content/meta/metasStyles";
import Button from "@library/forms/Button";
import { ButtonTypes } from "@library/forms/buttonStyles";
import { quoteSelection } from "@library/icons/editorIcons";
import { t } from "@library/utility/appUtils";
import { article } from "@library/icons/navigationManager";
import { rightChevron } from "@library/icons/common";
import { ContentInfo } from "@library/content/ContentInfo";
import { MetaText } from "@library/content/meta/MetaText";

export enum QuoteResourceType {
    COMMENT = "comment",
    DISCUSSION = "discussion",
    ARTICLE = "article",
}

export interface IRichQuoteRecord {
    name?: string;
    body: string; // Unsafe HTML content. Be sure to escape it.
    hasLinesBefore: boolean;
    hasLinesAfter: boolean;
    url: string;
    resourceType: QuoteResourceType;
    resourceID: number;
    author: IUserFragment;
    date: string;
}

interface IProps {
    data: IRichQuoteRecord;
}

interface IState {
    fullBody: ILoadable<string>;
}

interface IResourceInfo {
    iconFunction: (className?: string) => React.ReactNode;
    viewFullText: string;
}

function getResourceInfo(resourceType: QuoteResourceType): IResourceInfo {
    switch (resourceType) {
        case QuoteResourceType.COMMENT:
            return {
                iconFunction: article,
                viewFullText: t("View full comment"),
            };
        case QuoteResourceType.DISCUSSION: {
            return {
                iconFunction: article,
                viewFullText: t("View full discussion"),
            };
        }
        case QuoteResourceType.ARTICLE: {
            return {
                iconFunction: article,
                viewFullText: t("View full article"),
            };
        }
    }
}

export class RichQuote extends React.Component<IProps, IState> {
    public state: IState = {
        fullBody: {
            status: LoadStatus.PENDING,
        },
    };

    public render() {
        const { author, name, body, url, date, hasLinesAfter, hasLinesBefore, resourceType } = this.props.data;
        const resourceInfo = getResourceInfo(resourceType);
        const quoteClasses = richQuoteClasses();
        const classesMeta = metasClasses();

        return (
            <div className={quoteClasses.frame}>
                <header className={quoteClasses.header}>
                    <Button className={quoteClasses.selectionToggle} baseClass={ButtonTypes.ICON}>
                        {/* {quoteSelection()} */}
                    </Button>
                    <ContentInfo
                        user={author}
                        meta={
                            <MetaText>
                                <DateTime timestamp={date} />
                            </MetaText>
                        }
                    />
                </header>
                <div className={quoteClasses.main}>
                    <SmartLink className={quoteClasses.title} to={url}>
                        {name}
                    </SmartLink>
                    {hasLinesBefore && <ExtraLines />}
                    <blockquote
                        className={classNames(quoteClasses.quote, userContentClasses().root)}
                        dangerouslySetInnerHTML={{ __html: body }}
                    />
                    {hasLinesAfter && <ExtraLines />}
                </div>
                <footer className={quoteClasses.footer}>
                    <SmartLink className={quoteClasses.resourceLink} to={url}>
                        {resourceInfo.iconFunction(quoteClasses.resourceIcon)}
                        <span className={quoteClasses.resourceText}>{resourceInfo.viewFullText}</span>
                        {rightChevron(quoteClasses.resourceIcon)}
                    </SmartLink>
                </footer>
            </div>
        );
    }
}

interface IExpandQuoteProps {}

function ExtraLines(props: IExpandQuoteProps) {
    const content = "...";
    const classesQuote = richQuoteClasses();
    return <div className={classesQuote.expandButton}>{content}</div>;
}
