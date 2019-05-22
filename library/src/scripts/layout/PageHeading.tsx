/**
 * @author Stéphane LaFlèche <stephane.l@vanillaforums.com>
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import React from "react";
import classNames from "classnames";
import BackLink from "@library/routing/links/BackLink";
import Heading from "@library/layout/Heading";
import { pageHeadingClasses } from "@library/layout/pageHeadingStyles";
import backLinkClasses from "@library/routing/links/backLinkStyles";
import { LineHeightCalculatorContext } from "@library/layout/PageHeadingContext";

interface IPageHeading {
    title: string;
    children?: React.ReactNode;
    className?: string;
    headingClassName?: string;
    actions?: React.ReactNode;
    includeBackLink?: boolean;
}

/**
 * A component representing a top level page heading.
 * Can be configured with an options menu and a backlink.
 */
export default class PageHeading extends React.Component<IPageHeading> {
    public static defaultProps = {
        includeBackLink: true,
    };
    public context!: React.ContextType<typeof LineHeightCalculatorContext>;
    public titleRef: React.RefObject<HTMLHeadingElement>;

    public render() {
        const classes = pageHeadingClasses();
        const linkClasses = backLinkClasses();
        return (
            <div className={classNames(classes.root, this.props.className)}>
                <div className={classes.main}>
                    <div className={classes.titleWrap}>
                        {this.props.includeBackLink && (
                            <BackLink
                                className={linkClasses.forHeading(this.context.lineHeight)}
                                fallbackElement={null}
                            />
                        )}
                        <Heading
                            titleRef={this.titleRef}
                            depth={1}
                            title={this.props.title}
                            className={this.props.headingClassName}
                        >
                            {this.props.children}
                        </Heading>
                    </div>
                </div>
                {this.props.actions && (
                    <div className={classes.actions(this.context.lineHeight)}>{this.props.actions}</div>
                )}
            </div>
        );
    }

    public componentDidMount() {
        const breako = "here";
        const lineHeight = this.titleRef;
        // this.context.setLineHeight();
    }

    public componentWillUnmount() {
        this.context.unsetLineHeight();
    }
}
